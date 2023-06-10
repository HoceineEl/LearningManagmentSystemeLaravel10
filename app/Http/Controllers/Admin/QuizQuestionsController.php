<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.quizQuestions.index', compact('quizQuestions'));
    }

    public function index1($quiz)
    {
        abort_if(Gate::denies('quiz_question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $quiz1 = Quiz::findOrFail($quiz);
        $quizQuestions = $quiz1->quizQuizQuestions()->get() ?? [];
        // $quizQuestions = $quiz->questions ?? [];
        return view('admin.quizQuestions.index', compact('quizQuestions','quiz1'));
    }
    
    public function create($quiz)
    {
        abort_if(Gate::denies('quiz_question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $quizzes = Quiz::pluck('nom', 'id')->prepend(trans('global.pleaseSelect'), '');
        $quiz1 = Quiz::findOrFail($quiz);
        // $quizzes=$quiz;
        return view('admin.quizQuestions.create', compact('quiz1'));
    }

        public function store(StoreQuizQuestionRequest $request, $quiz)
    {
        $quizQuestion = QuizQuestion::create($request->all());
        // $quiz1 = Quiz::findOrFail($quiz);
        // $quizQuestions = $quiz1->quizQuizQuestions()->get() ?? [];
        return redirect()->route('admin.quiz-questions.index1',compact('quiz') );
        // return redirect()->route('admin.quiz-questions.index', $quiz1->id);
    }


    public function edit(QuizQuestion $quizQuestion)
    {
        abort_if(Gate::denies('quiz_question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $quizQuestion->load('quiz');
        return view('admin.quizQuestions.edit', compact('quizQuestion'));
    }

    public function update(Request $request, QuizQuestion $quizQuestion)
    {
        // $quizQuestion->update($request->all());
        $quizQuestion->update(['question' => $request->input('question')]);
        $quizQuestion->update(['ordre' => $request->input('ordre')]);
        return redirect()->route('admin.quiz-questions.index');
    }
    
    public function show(QuizQuestion $quizQuestion)
    {
        abort_if(Gate::denies('quiz_question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizQuestion->load('quiz', 'questionQuestionReponses');

        return view('admin.quizQuestions.show', compact('quizQuestion'));
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
