<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyScoreQuizRequest;
use App\Http\Requests\StoreScoreQuizRequest;
use App\Http\Requests\UpdateScoreQuizRequest;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\ScoreQuiz;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScoreQuizsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('score_quiz_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scoreQuizzes = ScoreQuiz::with(['lesson', 'quiz', 'utilisateur'])->get();

        return view('admin.scoreQuizzes.index', compact('scoreQuizzes'));
    }

    public function create()
    {
        abort_if(Gate::denies('score_quiz_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quizzes = Quiz::pluck('nom', 'id')->prepend(trans('global.pleaseSelect'), '');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.scoreQuizzes.create', compact('lessons', 'quizzes', 'utilisateurs'));
    }

    public function store(StoreScoreQuizRequest $request)
    {
        $scoreQuiz = ScoreQuiz::create($request->all());

        return redirect()->route('admin.score-quizzes.index');
    }

    public function edit(ScoreQuiz $scoreQuiz)
    {
        abort_if(Gate::denies('score_quiz_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quizzes = Quiz::pluck('nom', 'id')->prepend(trans('global.pleaseSelect'), '');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $scoreQuiz->load('lesson', 'quiz', 'utilisateur');

        return view('admin.scoreQuizzes.edit', compact('lessons', 'quizzes', 'scoreQuiz', 'utilisateurs'));
    }

    public function update(UpdateScoreQuizRequest $request, ScoreQuiz $scoreQuiz)
    {
        $scoreQuiz->update($request->all());

        return redirect()->route('admin.score-quizzes.index');
    }

    public function show(ScoreQuiz $scoreQuiz)
    {
        abort_if(Gate::denies('score_quiz_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scoreQuiz->load('lesson', 'quiz', 'utilisateur');

        return view('admin.scoreQuizzes.show', compact('scoreQuiz'));
    }

    public function destroy(ScoreQuiz $scoreQuiz)
    {
        abort_if(Gate::denies('score_quiz_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scoreQuiz->delete();

        return back();
    }

    public function massDestroy(MassDestroyScoreQuizRequest $request)
    {
        $scoreQuizzes = ScoreQuiz::find(request('ids'));

        foreach ($scoreQuizzes as $scoreQuiz) {
            $scoreQuiz->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
