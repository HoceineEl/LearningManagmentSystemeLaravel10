<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Jobs\GenerateResolutionsJob;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Symfony\Component\Filesystem\Filesystem;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::all();
        return view('videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'video' => 'required|mimetypes:video/*',
        ]);

        $videoFile = $request->file('video');

        if ($request->hasFile('video') && $videoFile->isValid()) {
            $filename = uniqid() . '_' . $videoFile->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            $storagePath = storage_path('app/public/videos');
            $fullPath = $this->moveVideoFile($videoFile, $storagePath, $filename);
            // Update Redis with initial progress and task


            //wait until the file uploaded successfully
            while (!file_exists($fullPath)) {
                usleep(1000);
            }

            // Update Redis with progress and task after file upload

            Queue::push(new GenerateResolutionsJob($storagePath, $filename, $request['title']));

            return redirect()->route('videos.create')->with('success', 'Video upload initiated successfully.');
        }

        $errorMessage = 'The video failed to upload: ' . $videoFile->getErrorMessage();
        return redirect()->back()->withErrors(['video' => $errorMessage]);
    }



    /**
     * Move the video file to storage and save a resolution.
     */
    private function moveVideoFile($videoFile, $storagePath, $filename)
    {
        Redis::set('video_conversion_progress', 0);
        Redis::set('current_task', 'Uploading');
        $path = $videoFile->move($storagePath, $filename);
        Redis::set('video_conversion_progress', 98);
        Redis::set('current_task', 'Uploading');
        return $path->getRealPath();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $video = Video::findOrFail($id);

        return view('videos.show', compact('video'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);

        return view('videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $video = Video::findOrFail($id);
        $video->title = $request->input('title');
        $video->save();

        return redirect()->route('videos.edit', $id)->with('success', 'Video updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     $video = Video::findOrFail($id);
    //     $resolutions = Resolution::where('video_id', $video->id)->get();

    //     // Delete video resolutions
    //     foreach ($resolutions as $resolution) {
    //         // Delete the resolution file
    //         $storagePath = storage_path('app/public/videos');
    //         $filePath = $storagePath . '/' . $resolution->path;
    //         if (file_exists($filePath)) {
    //             unlink($filePath);
    //         }

    //         // Delete the resolution from the database
    //         $resolution->delete();
    //     }

    //     // Delete the main video file
    //     $storagePath = storage_path('app/public/videos');
    //     $filePath = $storagePath . '/' . $video->filename;
    //     if (file_exists($filePath)) {
    //         unlink($filePath);
    //     }

    //     // Delete the video from the database
    //     $video->delete();
    //     return redirect()->route('videos.index')->with('success', 'Video and related files deleted successfully.');
    // }

    public function clear()
    {
        $videos = Video::all();
        foreach ($videos as $video) {
            $storagePath = storage_path('app/public/videos');
            $floderPath = $storagePath . '/' . str_replace('_0_1500.m3u8', '', $video->path);
            if (file_exists($floderPath)) {
                $filesystem = new Filesystem();
                $filesystem->remove($floderPath);
            }
            $video->delete();
        }

        return back();
    }
    public function getVideoConversionProgress()
    {
        $progress = Redis::get('video_conversion_progress');
        $currentTask = Redis::get('current_task');

        return response()->json([
            'progress' => $progress,
            'current_task' => $currentTask
        ]);
    }
}
