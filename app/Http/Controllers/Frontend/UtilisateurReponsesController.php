<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUtilisateurReponseRequest;
use App\Http\Requests\StoreUtilisateurReponseRequest;
use App\Http\Requests\UpdateUtilisateurReponseRequest;
use App\Models\QuestionReponse;
use App\Models\User;
use App\Models\UtilisateurReponse;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilisateurReponsesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('utilisateur_reponse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurReponses = UtilisateurReponse::with(['utilisateur', 'reponse'])->get();

        return view('frontend.utilisateurReponses.index', compact('utilisateurReponses'));
    }

    public function create()
    {
        abort_if(Gate::denies('utilisateur_reponse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reponses = QuestionReponse::pluck('reponse', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.utilisateurReponses.create', compact('reponses', 'utilisateurs'));
    }

    public function store(StoreUtilisateurReponseRequest $request)
    {
        $utilisateurReponse = UtilisateurReponse::create($request->all());

        return redirect()->route('frontend.utilisateur-reponses.index');
    }

    public function edit(UtilisateurReponse $utilisateurReponse)
    {
        abort_if(Gate::denies('utilisateur_reponse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reponses = QuestionReponse::pluck('reponse', 'id')->prepend(trans('global.pleaseSelect'), '');

        $utilisateurReponse->load('utilisateur', 'reponse');

        return view('frontend.utilisateurReponses.edit', compact('reponses', 'utilisateurReponse', 'utilisateurs'));
    }

    public function update(UpdateUtilisateurReponseRequest $request, UtilisateurReponse $utilisateurReponse)
    {
        $utilisateurReponse->update($request->all());

        return redirect()->route('frontend.utilisateur-reponses.index');
    }

    public function show(UtilisateurReponse $utilisateurReponse)
    {
        abort_if(Gate::denies('utilisateur_reponse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurReponse->load('utilisateur', 'reponse');

        return view('frontend.utilisateurReponses.show', compact('utilisateurReponse'));
    }

    public function destroy(UtilisateurReponse $utilisateurReponse)
    {
        abort_if(Gate::denies('utilisateur_reponse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurReponse->delete();

        return back();
    }

    public function massDestroy(MassDestroyUtilisateurReponseRequest $request)
    {
        $utilisateurReponses = UtilisateurReponse::find(request('ids'));

        foreach ($utilisateurReponses as $utilisateurReponse) {
            $utilisateurReponse->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
