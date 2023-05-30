<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyContenuRequest;
use App\Http\Requests\StoreContenuRequest;
use App\Http\Requests\UpdateContenuRequest;
use App\Models\Contenu;
use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ContenusController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('contenu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contenus = Contenu::with(['lesson'])->get();

        return view('frontend.contenus.index', compact('contenus'));
    }

    public function create()
    {
        abort_if(Gate::denies('contenu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.contenus.create', compact('lessons'));
    }

    public function store(StoreContenuRequest $request)
    {
        $contenu = Contenu::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $contenu->id]);
        }

        return redirect()->route('frontend.contenus.index');
    }

    public function edit(Contenu $contenu)
    {
        abort_if(Gate::denies('contenu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contenu->load('lesson');

        return view('frontend.contenus.edit', compact('contenu', 'lessons'));
    }

    public function update(UpdateContenuRequest $request, Contenu $contenu)
    {
        $contenu->update($request->all());

        return redirect()->route('frontend.contenus.index');
    }

    public function show(Contenu $contenu)
    {
        abort_if(Gate::denies('contenu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contenu->load('lesson', 'contenuVideos');

        return view('frontend.contenus.show', compact('contenu'));
    }

    public function destroy(Contenu $contenu)
    {
        abort_if(Gate::denies('contenu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contenu->delete();

        return back();
    }

    public function massDestroy(MassDestroyContenuRequest $request)
    {
        $contenus = Contenu::find(request('ids'));

        foreach ($contenus as $contenu) {
            $contenu->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('contenu_create') && Gate::denies('contenu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Contenu();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
