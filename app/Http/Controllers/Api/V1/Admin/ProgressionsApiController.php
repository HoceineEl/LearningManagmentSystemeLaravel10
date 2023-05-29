<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgressionRequest;
use App\Http\Requests\UpdateProgressionRequest;
use App\Http\Resources\Admin\ProgressionResource;
use App\Models\Progression;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgressionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('progression_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProgressionResource(Progression::with(['utilisateur', 'lesson'])->get());
    }

    public function store(StoreProgressionRequest $request)
    {
        $progression = Progression::create($request->all());

        return (new ProgressionResource($progression))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Progression $progression)
    {
        abort_if(Gate::denies('progression_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProgressionResource($progression->load(['utilisateur', 'lesson']));
    }

    public function update(UpdateProgressionRequest $request, Progression $progression)
    {
        $progression->update($request->all());

        return (new ProgressionResource($progression))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Progression $progression)
    {
        abort_if(Gate::denies('progression_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $progression->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
