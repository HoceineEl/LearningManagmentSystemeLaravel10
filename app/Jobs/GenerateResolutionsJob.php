<?php

namespace App\Jobs;

use App\Models\LessonVideo;
use Exception;
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
use Illuminate\Http\Request;


class GenerateResolutionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $lecon_id;
    protected $filename;
    protected $storagePath;

    /**
     * Create a new job instance.
     *
     * @param string $storagePath
     * @param string $filename
     * @param string $title
     * @param string $lecon_id
     */
    public function __construct(string $storagePath, string $filename, string $title,  $lecon_id)
    {
        $this->filename = $filename;
        $this->storagePath = $storagePath;
        $this->title = $title;
        $this->lecon_id = $lecon_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $this->updateConversionProgress('Watermarking', 0);
            $inputPath = $this->storagePath . '/' . $this->filename;
            $newFilename = pathinfo($this->filename, PATHINFO_FILENAME);
            $this->simulateWatermarkingProgress();
            // Add watermark to the original video
            $watermarkedFilename = $this->addWatermark($inputPath);

            // Simulate progress for watermarking


            // Create demo video
            $this->createDemoVideo($watermarkedFilename, $newFilename);

            // Generate resolutions
            $this->generateResolutions($newFilename);

            // Clean up files
            $this->cleanupFiles($inputPath, $watermarkedFilename);

            // Update completion status

        } catch (\Exception $e) {
            // Handle the exception and retrieve the error message
            $errorMessage = $e->getMessage();
            echo $errorMessage;
            // Log the error, return a response, or perform any other necessary action
            // based on the error message
        } finally {
            $this->updateConversionProgress('', 404);
        }
    }

    /**
     * Add watermark to the original video.
     *
     * @param string $inputPath
     * @return string
     */
    private function addWatermark(string $inputPath): string
    {
        $watermarkedFilename = storage_path('app/public/videos/watermarked_') . $this->filename;
        $watermarkImagePath = public_path('devo.png');

        $ffmpegCommand = "ffmpeg -i {$inputPath} -i {$watermarkImagePath} -filter_complex \"[0:v][1:v] overlay=W-w-10:H-h-10:enable='between(t,0,20)'\" -pix_fmt yuv420p -c:a copy {$watermarkedFilename}";
        exec($ffmpegCommand, $output, $returnCode);

        return $watermarkedFilename;
    }

    /**
     * Simulate progress for video conversion.
     */
    private function simulateWatermarkingProgress()
    {
        $progress = 0;
        while ($progress < 100) {
            sleep(1);
            $progress += rand(1, 20);
            if ($progress > 100) {
                $progress = 100;
            }
            $this->updateConversionProgress('Watermarking', $progress);
        }
    }

    /**
     * Create demo video.
     *
     * @param string $watermarkedFilename
     * @param string $newFilename
     */
    private function createDemoVideo(string $watermarkedFilename, string $newFilename)
    {
        $demoFFMpeg = FFMpeg::fromDisk('ffmpeg')
            ->open('watermarked_' . $this->filename)
            ->addFilter(new \FFMpeg\Filters\Video\ClipFilter(TimeCode::fromSeconds(0), TimeCode::fromSeconds(10)))
            ->export()
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(1280, 720));
            })
            ->onProgress(function ($progress) {
                $this->updateConversionProgress('Demo creation', $progress);
            })
            ->toDisk('public')
            ->inFormat(new X264('aac'))
            ->save('videos/' . $newFilename . '/demo.mp4');
    }

    /**
     * Generate resolutions.
     *
     * @param array $resolutions
     * @param string $newFilename
     */
    private function generateResolutions(string $newFilename)
    {

        try {

            $lowBitrate = (new X264)->setKiloBitrate(250);
            $midBitrate = (new X264)->setKiloBitrate(500);
            $highBitrate = (new X264)->setKiloBitrate(1000);
            $superBitrate = (new X264)->setKiloBitrate(1500);
            $video = FFMpeg::fromDisk('ffmpeg')
                ->open('watermarked_' . $this->filename)
                ->exportForHLS()
                ->setSegmentLength(2)
                ->addFormat($superBitrate)
                ->addFormat($highBitrate)
                ->addFormat($midBitrate)
                ->addFormat($lowBitrate)
                ->onProgress(function ($progress) {
                    $this->updateConversionProgress('HLS conversion', $progress);
                })
                ->toDisk('public')
                ->save('videos/' . $newFilename . '/' . $newFilename . '.m3u8');
            $duration = $video->getDurationInSeconds();
            $this->saveResolution($newFilename . '.m3u8', $duration);
            $filePath = $this->storagePath . '/'  . $newFilename . '/' . $newFilename . '.m3u8';
            $fileContent = file_get_contents($filePath);
            $replacements = [
                'RESOLUTION=1920x1080',
                'RESOLUTION=1920x720',
                'RESOLUTION=1920x480',
                'RESOLUTION=1920x144'
            ];

            $pattern = "/RESOLUTION=\d+x\d+/";

            $modifiedContent = preg_replace_callback($pattern, function ($matches) use (&$replacements) {
                return array_shift($replacements);
            }, $fileContent, 4);

            // Save the modified content back to the file
            file_put_contents($filePath, $modifiedContent);
        } catch (Exception $e) {
            echo 'error = ' . $e;
        }
    }

    /**
     * Save resolution information to database.
     *
     * @param string $outputFilename
     * @param float $duration
     */
    private function saveResolution(string $outputFilename, float $duration)
    {
        $resolutionModel = new LessonVideo();
        $resolutionModel->title = $this->title;
        $resolutionModel->lesson_id = $this->lecon_id;
        $resolutionModel->duration = $duration;
        $resolutionModel->path = $outputFilename;
        $resolutionModel->save();
    }

    /**
     * Clean up files.
     *
     * @param string $inputPath
     * @param string $watermarkedFilename
     */
    private function cleanupFiles(string $inputPath, string $watermarkedFilename)
    {
        unlink($inputPath);
        unlink($watermarkedFilename);
    }

    /**
     * Update the progress of video conversion.
     *
     * @param string $task
     * @param int $progress
     */
    private function updateConversionProgress(string $task, int $progress)
    {
        Redis::set('current_task', $task);
        Redis::set('video_conversion_progress', $progress);
        echo "Progress: " . $progress . ' %' . PHP_EOL;
    }
}
