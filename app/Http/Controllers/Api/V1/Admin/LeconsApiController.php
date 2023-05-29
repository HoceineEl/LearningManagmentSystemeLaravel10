<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeconRequest;
use App\Http\Requests\UpdateLeconRequest;
use App\Http\Resources\Admin\LeconResource;
use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeconsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeconResource(Lesson::with(['section'])->get());
    }

    public function store(StoreLeconRequest $request)
    {
        $lesson = Lesson::create($request->all());

        return (new LeconResource($lesson))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Lesson $lecon)
    {
        abort_if(Gate::denies('lesson_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeconResource($lecon->load(['section']));
    }

    public function update(UpdateLeconRequest $request, Lesson $lecon)
    {
        $lecon->update($request->all());

        return (new LeconResource($lecon))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Lesson $lecon)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lecon->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
