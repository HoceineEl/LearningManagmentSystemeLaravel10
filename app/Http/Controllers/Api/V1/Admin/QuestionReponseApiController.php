<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionReponseRequest;
use App\Http\Requests\UpdateQuestionReponseRequest;
use App\Http\Resources\Admin\QuestionReponseResource;
use App\Models\QuestionReponse;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionReponseApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('question_reponse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionReponseResource(QuestionReponse::with(['question'])->get());
    }

    public function store(StoreQuestionReponseRequest $request)
    {
        $questionReponse = QuestionReponse::create($request->all());

        return (new QuestionReponseResource($questionReponse))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(QuestionReponse $questionReponse)
    {
        abort_if(Gate::denies('question_reponse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionReponseResource($questionReponse->load(['question']));
    }

    public function update(UpdateQuestionReponseRequest $request, QuestionReponse $questionReponse)
    {
        $questionReponse->update($request->all());

        return (new QuestionReponseResource($questionReponse))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(QuestionReponse $questionReponse)
    {
        abort_if(Gate::denies('question_reponse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionReponse->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
