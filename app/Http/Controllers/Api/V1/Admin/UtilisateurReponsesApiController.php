<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUtilisateurReponseRequest;
use App\Http\Requests\UpdateUtilisateurReponseRequest;
use App\Http\Resources\Admin\UtilisateurReponseResource;
use App\Models\UtilisateurReponse;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilisateurReponsesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('utilisateur_reponse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UtilisateurReponseResource(UtilisateurReponse::with(['utilisateur', 'reponse'])->get());
    }

    public function store(StoreUtilisateurReponseRequest $request)
    {
        $utilisateurReponse = UtilisateurReponse::create($request->all());

        return (new UtilisateurReponseResource($utilisateurReponse))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UtilisateurReponse $utilisateurReponse)
    {
        abort_if(Gate::denies('utilisateur_reponse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UtilisateurReponseResource($utilisateurReponse->load(['utilisateur', 'reponse']));
    }

    public function update(UpdateUtilisateurReponseRequest $request, UtilisateurReponse $utilisateurReponse)
    {
        $utilisateurReponse->update($request->all());

        return (new UtilisateurReponseResource($utilisateurReponse))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UtilisateurReponse $utilisateurReponse)
    {
        abort_if(Gate::denies('utilisateur_reponse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurReponse->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
