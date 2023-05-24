<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Resources\Admin\VideoResource;
use App\Models\Video;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideosApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoResource(Video::with(['contenu'])->get());
    }

    public function store(StoreVideoRequest $request)
    {
        $video = Video::create($request->all());

        if ($request->input('video', false)) {
            $video->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
        }

        if ($request->input('miniature', false)) {
            $video->addMedia(storage_path('tmp/uploads/' . basename($request->input('miniature'))))->toMediaCollection('miniature');
        }

        return (new VideoResource($video))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Video $video)
    {
        abort_if(Gate::denies('video_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoResource($video->load(['contenu']));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $video->update($request->all());

        if ($request->input('video', false)) {
            if (! $video->video || $request->input('video') !== $video->video->file_name) {
                if ($video->video) {
                    $video->video->delete();
                }
                $video->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
            }
        } elseif ($video->video) {
            $video->video->delete();
        }

        if ($request->input('miniature', false)) {
            if (! $video->miniature || $request->input('miniature') !== $video->miniature->file_name) {
                if ($video->miniature) {
                    $video->miniature->delete();
                }
                $video->addMedia(storage_path('tmp/uploads/' . basename($request->input('miniature'))))->toMediaCollection('miniature');
            }
        } elseif ($video->miniature) {
            $video->miniature->delete();
        }

        return (new VideoResource($video))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Video $video)
    {
        abort_if(Gate::denies('video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $video->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
