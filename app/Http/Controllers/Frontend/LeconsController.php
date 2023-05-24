<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeconRequest;
use App\Http\Requests\StoreLeconRequest;
use App\Http\Requests\UpdateLeconRequest;
use App\Models\Lecon;
use App\Models\Section;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeconsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lecon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lecons = Lecon::with(['section'])->get();

        return view('frontend.lecons.index', compact('lecons'));
    }

    public function create()
    {
        abort_if(Gate::denies('lecon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.lecons.create', compact('sections'));
    }

    public function store(StoreLeconRequest $request)
    {
        $lecon = Lecon::create($request->all());

        return redirect()->route('frontend.lecons.index');
    }

    public function edit(Lecon $lecon)
    {
        abort_if(Gate::denies('lecon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lecon->load('section');

        return view('frontend.lecons.edit', compact('lecon', 'sections'));
    }

    public function update(UpdateLeconRequest $request, Lecon $lecon)
    {
        $lecon->update($request->all());

        return redirect()->route('frontend.lecons.index');
    }

    public function show(Lecon $lecon)
    {
        abort_if(Gate::denies('lecon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lecon->load('section', 'leconQuizzes', 'leconScoreQuizzes', 'leconProgressions', 'leconCommentaires', 'leconContenus');

        return view('frontend.lecons.show', compact('lecon'));
    }

    public function destroy(Lecon $lecon)
    {
        abort_if(Gate::denies('lecon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lecon->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeconRequest $request)
    {
        $lecons = Lecon::find(request('ids'));

        foreach ($lecons as $lecon) {
            $lecon->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
