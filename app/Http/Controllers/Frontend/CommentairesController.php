<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCommentaireRequest;
use App\Http\Requests\StoreCommentaireRequest;
use App\Http\Requests\UpdateCommentaireRequest;
use App\Models\Commentaire;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CommentairesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('commentaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commentaires = Commentaire::with(['lesson', 'utilisateur', 'parent'])->get();

        return view('frontend.commentaires.index', compact('commentaires'));
    }

    public function create()
    {
        abort_if(Gate::denies('commentaire_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.commentaires.create', compact('lessons', 'utilisateurs'));
    }

    public function store(StoreCommentaireRequest $request)
    {
        $commentaire = Commentaire::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $commentaire->id]);
        }

        return redirect()->route('frontend.commentaires.index');
    }

    public function edit(Commentaire $commentaire)
    {
        abort_if(Gate::denies('commentaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $commentaire->load('lesson', 'utilisateur', 'parent');

        return view('frontend.commentaires.edit', compact('commentaire', 'lessons', 'utilisateurs'));
    }

    public function update(UpdateCommentaireRequest $request, Commentaire $commentaire)
    {
        $commentaire->update($request->all());

        return redirect()->route('frontend.commentaires.index');
    }

    public function show(Commentaire $commentaire)
    {
        abort_if(Gate::denies('commentaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commentaire->load('lesson', 'utilisateur', 'parent', 'parentCommentaires');

        return view('frontend.commentaires.show', compact('commentaire'));
    }

    public function destroy(Commentaire $commentaire)
    {
        abort_if(Gate::denies('commentaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commentaire->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommentaireRequest $request)
    {
        $commentaires = Commentaire::find(request('ids'));

        foreach ($commentaires as $commentaire) {
            $commentaire->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('commentaire_create') && Gate::denies('commentaire_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Commentaire();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
