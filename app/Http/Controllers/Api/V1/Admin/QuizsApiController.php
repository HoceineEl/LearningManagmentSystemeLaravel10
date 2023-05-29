<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Http\Resources\Admin\QuizResource;
use App\Models\Quiz;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('quiz_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuizResource(Quiz::with(['lesson'])->get());
    }

    public function store(StoreQuizRequest $request)
    {
        $quiz = Quiz::create($request->all());

        return (new QuizResource($quiz))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuizResource($quiz->load(['lesson']));
    }

    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->all());

        return (new QuizResource($quiz))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
