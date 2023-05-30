<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreContenuRequest;
use App\Http\Requests\UpdateContenuRequest;
use App\Http\Resources\Admin\ContenuResource;
use App\Models\Contenu;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContenusApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('contenu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContenuResource(Contenu::with(['lesson'])->get());
    }

    public function store(StoreContenuRequest $request)
    {
        $contenu = Contenu::create($request->all());

        return (new ContenuResource($contenu))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Contenu $contenu)
    {
        abort_if(Gate::denies('contenu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContenuResource($contenu->load(['lesson']));
    }

    public function update(UpdateContenuRequest $request, Contenu $contenu)
    {
        $contenu->update($request->all());

        return (new ContenuResource($contenu))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Contenu $contenu)
    {
        abort_if(Gate::denies('contenu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contenu->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
