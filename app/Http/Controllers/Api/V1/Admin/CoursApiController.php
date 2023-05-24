<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCourRequest;
use App\Http\Requests\UpdateCourRequest;
use App\Http\Resources\Admin\CourResource;
use App\Models\Cour;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cour_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourResource(Cour::with(['auteur'])->get());
    }

    public function store(StoreCourRequest $request)
    {
        $cour = Cour::create($request->all());

        if ($request->input('cover', false)) {
            $cour->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover'))))->toMediaCollection('cover');
        }

        return (new CourResource($cour))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Cour $cour)
    {
        abort_if(Gate::denies('cour_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourResource($cour->load(['auteur']));
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

        return (new CourResource($cour))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Cour $cour)
    {
        abort_if(Gate::denies('cour_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cour->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
