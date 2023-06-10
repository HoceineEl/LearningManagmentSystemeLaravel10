<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuizQuestionRequest;
use App\Http\Requests\StoreQuizQuestionRequest;
use App\Http\Requests\UpdateQuizQuestionRequest;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizQuestionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('quiz_question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizQuestions = QuizQuestion::with(['quiz'])->get();

        return view('frontend.quizQuestions.index', compact('quizQuestions'));
    }

    public function create()
    {
        abort_if(Gate::denies('quiz_question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizzes = Quiz::pluck('nom', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.quizQuestions.create', compact('quizzes'));
    }

    public function store(StoreQuizQuestionRequest $request)
    {
        $quizQuestion = QuizQuestion::create($request->all());

        return redirect()->route('frontend.quiz-questions.index');
    }

    public function edit(QuizQuestion $quizQuestion)
    {
        abort_if(Gate::denies('quiz_question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizzes = Quiz::pluck('nom', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quizQuestion->load('quiz');

        return view('frontend.quizQuestions.edit', compact('quizQuestion', 'quizzes'));
    }

    public function update(UpdateQuizQuestionRequest $request, QuizQuestion $quizQuestion)
    {
        $quizQuestion->update($request->all());

        return redirect()->route('frontend.quiz-questions.index');
    }

    public function show(QuizQuestion $quizQuestion)
    {
        abort_if(Gate::denies('quiz_question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizQuestion->load('quiz', 'questionQuestionReponses');

        return view('frontend.quizQuestions.show', compact('quizQuestion'));
    }

    public function destroy(QuizQuestion $quizQuestion)
    {
        abort_if(Gate::denies('quiz_question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizQuestion->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuizQuestionRequest $request)
    {
        $quizQuestions = QuizQuestion::find(request('ids'));

        foreach ($quizQuestions as $quizQuestion) {
            $quizQuestion->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }


    






}
