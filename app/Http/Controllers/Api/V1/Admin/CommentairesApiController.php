<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCommentaireRequest;
use App\Http\Requests\UpdateCommentaireRequest;
use App\Http\Resources\Admin\CommentaireResource;
use App\Models\Commentaire;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentairesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('commentaire_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CommentaireResource(Commentaire::with(['lesson', 'utilisateur', 'parent'])->get());
    }

    public function store(StoreCommentaireRequest $request)
    {
        $commentaire = Commentaire::create($request->all());

        return (new CommentaireResource($commentaire))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Commentaire $commentaire)
    {
        abort_if(Gate::denies('commentaire_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CommentaireResource($commentaire->load(['lesson', 'utilisateur', 'parent']));
    }

    public function update(UpdateCommentaireRequest $request, Commentaire $commentaire)
    {
        $commentaire->update($request->all());

        return (new CommentaireResource($commentaire))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Commentaire $commentaire)
    {
        abort_if(Gate::denies('commentaire_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commentaire->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
