<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuizRequest;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Lecon;
use App\Models\Quiz;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('quiz_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizzes = Quiz::with(['lecon'])->get();

        return view('frontend.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        abort_if(Gate::denies('quiz_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lecons = Lecon::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.quizzes.create', compact('lecons'));
    }

    public function store(StoreQuizRequest $request)
    {
        $quiz = Quiz::create($request->all());

        return redirect()->route('frontend.quizzes.index');
    }

    public function edit(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lecons = Lecon::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quiz->load('lecon');

        return view('frontend.quizzes.edit', compact('lecons', 'quiz'));
    }

    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->all());

        return redirect()->route('frontend.quizzes.index');
    }

    public function show(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->load('lecon', 'quizQuizQuestions', 'quizScoreQuizzes');

        return view('frontend.quizzes.show', compact('quiz'));
    }

    public function destroy(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuizRequest $request)
    {
        $quizzes = Quiz::find(request('ids'));

        foreach ($quizzes as $quiz) {
            $quiz->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
