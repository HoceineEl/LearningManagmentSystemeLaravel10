<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProgressionRequest;
use App\Http\Requests\StoreProgressionRequest;
use App\Http\Requests\UpdateProgressionRequest;
use App\Models\Lesson;
use App\Models\Progression;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgressionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('progression_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $progressions = Progression::with(['utilisateur', 'lesson'])->get();

        return view('admin.progressions.index', compact('progressions'));
    }

    public function create()
    {
        abort_if(Gate::denies('progression_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.progressions.create', compact('lessons', 'utilisateurs'));
    }

    public function store(StoreProgressionRequest $request)
    {
        $progression = Progression::create($request->all());

        return redirect()->route('admin.progressions.index');
    }

    public function edit(Progression $progression)
    {
        abort_if(Gate::denies('progression_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $utilisateurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $progression->load('utilisateur', 'lesson');

        return view('admin.progressions.edit', compact('lessons', 'progression', 'utilisateurs'));
    }

    public function update(UpdateProgressionRequest $request, Progression $progression)
    {
        $progression->update($request->all());

        return redirect()->route('admin.progressions.index');
    }

    public function show(Progression $progression)
    {
        abort_if(Gate::denies('progression_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $progression->load('utilisateur', 'lesson');

        return view('admin.progressions.show', compact('progression'));
    }

    public function destroy(Progression $progression)
    {
        abort_if(Gate::denies('progression_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $progression->delete();

        return back();
    }

    public function massDestroy(MassDestroyProgressionRequest $request)
    {
        $progressions = Progression::find(request('ids'));

        foreach ($progressions as $progression) {
            $progression->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
