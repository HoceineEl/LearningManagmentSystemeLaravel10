<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuestionReponseRequest;
use App\Http\Requests\StoreQuestionReponseRequest;
use App\Http\Requests\UpdateQuestionReponseRequest;
use App\Models\QuestionReponse;
use App\Models\QuizQuestion;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionReponseController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('question_reponse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionReponses = QuestionReponse::with(['question'])->get();

        return view('frontend.questionReponses.index', compact('questionReponses'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_reponse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = QuizQuestion::pluck('question', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.questionReponses.create', compact('questions'));
    }

    public function store(StoreQuestionReponseRequest $request)
    {
        $questionReponse = QuestionReponse::create($request->all());

        return redirect()->route('frontend.question-reponses.index');
    }

    public function edit(QuestionReponse $questionReponse)
    {
        abort_if(Gate::denies('question_reponse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = QuizQuestion::pluck('question', 'id')->prepend(trans('global.pleaseSelect'), '');

        $questionReponse->load('question');

        return view('frontend.questionReponses.edit', compact('questionReponse', 'questions'));
    }

    public function update(UpdateQuestionReponseRequest $request, QuestionReponse $questionReponse)
    {
        $questionReponse->update($request->all());

        return redirect()->route('frontend.question-reponses.index');
    }

    public function show(QuestionReponse $questionReponse)
    {
        abort_if(Gate::denies('question_reponse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionReponse->load('question', 'reponseUtilisateurReponses');

        return view('frontend.questionReponses.show', compact('questionReponse'));
    }

    public function destroy(QuestionReponse $questionReponse)
    {
        abort_if(Gate::denies('question_reponse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionReponse->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuestionReponseRequest $request)
    {
        $questionReponses = QuestionReponse::find(request('ids'));

        foreach ($questionReponses as $questionReponse) {
            $questionReponse->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
