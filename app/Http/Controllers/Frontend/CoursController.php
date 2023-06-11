<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCourRequest;
use App\Http\Requests\StoreCourRequest;
use App\Http\Requests\UpdateCourRequest;
use App\Models\Cour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CoursController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cour_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cours = Cour::with(['auteur', 'media'])->get();

        return view('frontend.cours.index', compact('cours'));
    }

    public function create()
    {
        abort_if(Gate::denies('cour_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $auteurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.cours.create', compact('auteurs'));
    }

    public function store(StoreCourRequest $request)
    {
        $cour = Cour::create($request->all());

        if ($request->input('cover', false)) {
            $cour->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cour->id]);
        }

        return redirect()->route('frontend.cours.index');
    }

    public function edit(Cour $cour)
    {
        abort_if(Gate::denies('cour_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $auteurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cour->load('auteur');

        return view('frontend.cours.edit', compact('auteurs', 'cour'));
    }

    public function update(UpdateCourRequest $request, Cour $cour)
    {
        $cour->update($request->all());

        if ($request->hasFile('cover')) {
            if (!$cour->cover || $request->file('cover')->getClientOriginalName() !== $cour->cover->file_name) {
                if ($cour->cover) {
                    $cour->cover->delete();
                }
                $cour->addMediaFromRequest('cover')->toMediaCollection('cover');
            }
        } elseif ($cour->cover) {
            $cour->cover->delete();
        }

        return redirect()->route('frontend.cours.index');
    }


    public function show($cour)
    {
        $course = Cour::find($cour);
        $video = null;

        if ($course) {
            $section = $course->sections->where('position', '1')->first();

            if ($section) {
                $lesson = $section->lessons->where('position', '1')->first();

                if ($lesson->videos) {
                    $video = $lesson->videos->first();
                }
            }
        }
        return view('frontend.cours.show', compact('course', 'video'));
    }


    public function destroy(Cour $cour)
    {
        abort_if(Gate::denies('cour_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cour->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourRequest $request)
    {
        $cours = Cour::find(request('ids'));

        foreach ($cours as $cour) {
            $cour->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cour_create') && Gate::denies('cour_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Cour();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
