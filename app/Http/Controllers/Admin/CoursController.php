<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCourRequest;
use App\Http\Requests\StoreCourRequest;
use App\Http\Requests\UpdateCourRequest;
use App\Models\Cour;
use App\Models\User;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CoursController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cour_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cours = Cour::with(['auteur', 'media'])->get();

        return view('admin.cours.index', compact('cours'));
    }

    public function create()
    {
        abort_if(Gate::denies('cour_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $auteurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.cours.create', compact('auteurs'));
    }

    public function store(StoreCourRequest $request)
    {
        $cour = new Cour($request->all());
        $cour->auteur_id = auth()->id();
        $cour->save();

        if ($request->input('cover', false)) {
            $cour->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cour->id]);
        }

        return redirect()->route('admin.cours.index');
    }

    public function edit(Cour $cour)
    {
        abort_if(Gate::denies('cour_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $auteurs = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cour->load('auteur');

        return view('admin.cours.edit', compact('auteurs', 'cour'));
    }

    public function update(UpdateCourRequest $request, Cour $cour)
    {
        $cour->update($request->all());

        if ($request->input('cover', false)) {
            if (! $cour->cover || $request->input('cover') !== $cour->cover->file_name) {
                if ($cour->cover) {
                    $cour->cover->delete();
                }
                $cour->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
            }
        } elseif ($cour->cover) {
            $cour->cover->delete();
        }

        return redirect()->route('admin.cours.index');
    }

    public function show(Cour $cour)
    {
        abort_if(Gate::denies('cour_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::where('cour_id', $cour->id)->orderBy('position')->get();
        $sectionIds = $sections->pluck('id')->toArray();
        
        $lessons = Lesson::whereIn('section_id', $sectionIds)->orderBy('position')->get()->groupBy('section_id');
    
        return view('admin.lessons.index', ['lessons' => $lessons, 'sections' => $sections,'cour'=>$cour->id]);
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
