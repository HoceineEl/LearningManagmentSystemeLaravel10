<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.questionReponses.index', compact('questionReponses'));
    }

    public function index1($question)
    {
        abort_if(Gate::denies('question_reponse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $question = QuizQuestion::findOrFail($question);
        $questionReponses = $question->questionQuestionReponses()->get() ?? [];
        // $quizQuestions = $quiz->questions ?? [];
        return view('admin.questionReponses.index', compact('questionReponses','question'));
    }


    public function create($question)
    {
        abort_if(Gate::denies('question_reponse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $questions = QuizQuestion::pluck('question', 'id')->prepend(trans('global.pleaseSelect'), '');
        $questions = QuizQuestion::findOrFail($question);
        // dd($questions);
        return view('admin.questionReponses.create', compact('questions'));
    }


    public function store(StoreQuestionReponseRequest $request,$question)
    {

        $questionReponse = QuestionReponse::create($request->all());
        return redirect()->route('admin.questionReponses.index1',compact('question'));

    }




    public function edit(QuestionReponse $questionReponse)
    {
        abort_if(Gate::denies('question_reponse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $questions = QuizQuestion::pluck('question', 'id')->prepend(trans('global.pleaseSelect'), '');

        $questionReponse->load('question');

        return view('admin.questionReponses.edit', compact('questionReponse'));
    }


    public function update(Request $request, QuestionReponse $questionReponse)
    {
        // $questionReponse->update($request->all());
        $questionReponse->update(['reponse' => $request->input('reponse')]);
        $questionReponse->update(['est_correct' => $request->input('est_correct')]);
        return redirect()->route('admin.question-reponses.index');
    }

    public function show(QuestionReponse $questionReponse)
    {
        abort_if(Gate::denies('question_reponse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionReponse->load('question', 'reponseUtilisateurReponses');

        return view('admin.questionReponses.show', compact('questionReponse'));
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
