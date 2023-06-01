<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateResolutionsJob;
use App\Models\Lesson;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = LessonVideo::all();
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Lesson $lesson)
    {
        return view('admin.videos.create', compact('lesson'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        set_time_limit(0);
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
            Redis::set('current_task', 'Uploading');
            Redis::set('video_conversion_progress', 20);

            // Wait until the file is uploaded successfully
            while (!file_exists($fullPath)) {
                usleep(1000);
                Redis::set('video_conversion_progress', 80);
            }

            // Update Redis with progress and task after file upload
            Redis::set('current_task', 'Processing');
            Redis::set('video_conversion_progress', 100);
            

            // Perform any additional tasks (e.g., video conversion, watermarking, etc.)
            Queue::push(new GenerateResolutionsJob($storagePath, $filename, $request['title'], $request['lecon_id']));

            // Get the URL for the video
            $videoUrl = asset('storage/videos/' . $filename);

            // Return success response with the video URL

        }

        $errorMessage = 'The video failed to upload: ' . $videoFile->getErrorMessage();
        return response()->json(['error' => $errorMessage], 400);
    }



    /**
     * Move the video file to storage and save a resolution.
     */
    private function moveVideoFile($videoFile, $storagePath, $filename)
    {

        $path = $videoFile->move($storagePath, $filename);
        return $path->getRealPath();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $video = LessonVideo::findOrFail($id);

        return view('admin.videos.show', compact('video'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $video = LessonVideo::findOrFail($id);

        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $video = LessonVideo::findOrFail($id);
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
    //     $video = LessonVideo::findOrFail($id);
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
        $videos = LessonVideo::all();
        foreach ($videos as $video) {

            $video->delete();
        }
        $storagePath = storage_path('app/public/videos');

        if (file_exists($storagePath)) {

            File::deleteDirectory($storagePath);
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
