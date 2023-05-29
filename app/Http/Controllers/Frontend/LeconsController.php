<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeconRequest;
use App\Http\Requests\StoreLeconRequest;
use App\Http\Requests\UpdateLeconRequest;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeconsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::with(['section'])->get();

        return view('frontend.lecons.index', compact('lessons'));
    }

    public function create()
    {
        abort_if(Gate::denies('lecon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.lecons.create', compact('sections'));
    }

    public function store(StoreLeconRequest $request)
    {
        $lecon = Lesson::create($request->all());

        return redirect()->route('frontend.lessons.index');
    }

    public function edit(Lesson $lesson)
    {
        abort_if(Gate::denies('lecon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lesson->load('section');

        return view('frontend.lecons.edit', compact('lecon', 'sections'));
    }

    public function update(UpdateLeconRequest $request, Lesson $lesson)
    {
        $lesson->update($request->all());

        return redirect()->route('frontend.lecons.index');
    }

    public function show(Lesson $lesson)
    {
        abort_if(Gate::denies('lecon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->load('section', 'leconQuizzes', 'leconScoreQuizzes', 'leconProgressions', 'leconCommentaires', 'leconContenus');

        return view('frontend.lecons.show', compact('lecon'));
    }

    public function destroy(Lesson $lecon)
    {
        abort_if(Gate::denies('lecon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lecon->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeconRequest $request)
    {
        $lecons = Lesson::find(request('ids'));

        foreach ($lecons as $lecon) {
            $lecon->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
