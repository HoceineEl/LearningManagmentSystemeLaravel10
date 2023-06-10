<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuizRequest;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('quiz_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $quizzes = Quiz::with(['lesson'])->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create($lesson)
    {
        abort_if(Gate::denies('quiz_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $quiz = Quiz::where('lesson_id', $lesson)->first();
        if ($quiz) {
            $quizzes = Quiz::where('lesson_id', $lesson)->get();
            return view('admin.quizzes.index', compact('quizzes'));
        }
        return view('admin.quizzes.create', compact('lesson'));
    }
        
    public function store(StoreQuizRequest $request)
    {
        $quiz =Quiz::create($request->all());
        $lesson=$quiz->lesson_id;
        return redirect()->route('admin.quizzes.index',compact('lesson'));
    }   

    public function edit(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $lessons = Lesson::pluck('label','id')->prepend(trans('global.pleaseSelect'), '');
        $quiz->load('lesson');
        return view('admin.quizzes.edit', compact('quiz'));
    }
    // UpdateQuizRequest
    public function update(Request $request, Quiz $quiz)
    {
    $quiz->update(['nom' => $request->input('nom')]);
    return redirect()->route('admin.quizzes.index');
    }


    public function show(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->load('lesson', 'quizQuizQuestions', 'quizScoreQuizzes');

        return view('admin.quizzes.show', compact('quiz'));
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
