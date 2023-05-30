<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVideoRequest;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Contenu;
use App\Models\Video;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class VideosController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::with(['contenu', 'media'])->get();

        return view('frontend.videos.index', compact('videos'));
    }

    public function create()
    {
        abort_if(Gate::denies('video_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contenus = Contenu::pluck('ordre', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.videos.create', compact('contenus'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $video->id]);
        }

        return redirect()->route('frontend.videos.index');
    }

    public function edit(Video $video)
    {
        abort_if(Gate::denies('video_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contenus = Contenu::pluck('ordre', 'id')->prepend(trans('global.pleaseSelect'), '');

        $video->load('contenu');

        return view('frontend.videos.edit', compact('contenus', 'video'));
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

        return redirect()->route('frontend.videos.index');
    }

    public function show(Video $video)
    {
        abort_if(Gate::denies('video_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $video->load('contenu');

        return view('frontend.videos.show', compact('video'));
    }

    public function destroy(Video $video)
    {
        abort_if(Gate::denies('video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $video->delete();

        return back();
    }

    public function massDestroy(MassDestroyVideoRequest $request)
    {
        $videos = Video::find(request('ids'));

        foreach ($videos as $video) {
            $video->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('video_create') && Gate::denies('video_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Video();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
