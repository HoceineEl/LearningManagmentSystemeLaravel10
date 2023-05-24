<?php

namespace App\Jobs;

use App\Models\Resolution;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use ProtoneMedia\LaravelFFMpeg\Exporters\Concatenate;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GenerateResolutionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $filename;
    protected $storagePath;

    /**
     * Create a new job instance.
     *
     * @param string $storagePath
     * @param string $filename
     * @param string $title
     * @return void
     **/
    public function __construct(string $storagePath, string $filename, string $title)
    {
        $this->filename = $filename;
        $this->storagePath = $storagePath;
        $this->title = $title;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inputPath = $this->storagePath . '/' . $this->filename;
        $newFilename = pathinfo($this->filename, PATHINFO_FILENAME);
        $resolutions = ['1500'];
        $totalResolutions = count($resolutions);
        $currentResolution = 1;

        try {
            // Add watermark to the original video
            $watermarkedFilename = storage_path('app/public/videos/watermarked_') . $this->filename;
            $watermarkImagePath = public_path('devo.png');
            $ffmpegCommand = "ffmpeg -i {$inputPath} -i {$watermarkImagePath} -filter_complex \"[0:v][1:v] overlay=W-w-10:H-h-10:enable='between(t,0,20)'\" -pix_fmt yuv420p -c:a copy {$watermarkedFilename}";
            Redis::set('current_task', 'Watermarking');
            exec($ffmpegCommand);
            $start = \FFMpeg\Coordinate\TimeCode::fromSeconds(0);
            $duration = \FFMpeg\Coordinate\TimeCode::fromSeconds(10);
            $clipFilter = new \FFMpeg\Filters\Video\ClipFilter($start, $duration);
            $demoFFMpeg = FFMpeg::fromDisk('ffmpeg')
                ->open('watermarked_' . $this->filename)
                ->addFilter($clipFilter)
                ->export()
                ->addFilter(function ($filters) {
                    $filters->resize(new Dimension(1280, 720));
                })
                ->onProgress(function ($progress) {
                    Redis::set('video_conversion_progress', $progress);
                    Redis::set('current_task', 'Demo creation');
                    echo "Progress: " . $progress . ' %' . PHP_EOL;
                })
                ->toDisk('public')
                ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
                ->save('videos/' . $newFilename . '/demo.mp4');



            // Iterate over the resolutions and add them as formats
            foreach ($resolutions as $resolution) {
                $format = (new X264('aac'))->setKiloBitrate($resolution);
                $video = FFMpeg::fromDisk('ffmpeg')
                    ->open('watermarked_' . $this->filename)
                    ->exportForHLS()
                    ->setSegmentLength(10)
                    ->addFormat($format)
                    ->onProgress(
                        function ($percentage) use ($currentResolution, $totalResolutions) {
                            $progress = round(($currentResolution - 1 + ($percentage / 100)) / $totalResolutions * 100);
                            Redis::set('video_conversion_progress', $progress);
                            Redis::set('current_task', 'HLS conversion');
                            echo "Progress: " . $progress . ' %' . PHP_EOL;
                        }
                    )
                    ->toDisk('public')
                    ->save('videos/' . $newFilename . '/' . $newFilename . '.m3u8');

                $this->saveResolution($newFilename . '_0_' . $resolution . '.m3u8');
                $currentResolution++;
            }

            // Delete the original video file, watermarked video, and the old resolution from the database
            unlink($inputPath);
            unlink($watermarkedFilename);
            // Resolution::where('resolution', '1080')->delete();
        } catch (\Exception $e) {
            // Handle the exception and retrieve the error message
            $errorMessage = $e->getMessage();
            echo $errorMessage;
            // Log the error, return a response, or perform any other necessary action
            // based on the error message
        } finally {
            Redis::set('current_task', '');
            Redis::set('video_conversion_progress', '0');
        }
    }

    private function saveResolution($outputFilename)
    {
        $resolutionModel = new Video();
        $resolutionModel->title = $this->title;
        $resolutionModel->path = $outputFilename;
        $resolutionModel->save();
    }
}
