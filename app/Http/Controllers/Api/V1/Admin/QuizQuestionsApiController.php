<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizQuestionRequest;
use App\Http\Requests\UpdateQuizQuestionRequest;
use App\Http\Resources\Admin\QuizQuestionResource;
use App\Models\QuizQuestion;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizQuestionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('quiz_question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuizQuestionResource(QuizQuestion::with(['quiz'])->get());
    }

    public function store(StoreQuizQuestionRequest $request)
    {
        $quizQuestion = QuizQuestion::create($request->all());

        return (new QuizQuestionResource($quizQuestion))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(QuizQuestion $quizQuestion)
    {
        abort_if(Gate::denies('quiz_question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuizQuestionResource($quizQuestion->load(['quiz']));
    }

    public function update(UpdateQuizQuestionRequest $request, QuizQuestion $quizQuestion)
    {
        $quizQuestion->update($request->all());

        return (new QuizQuestionResource($quizQuestion))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(QuizQuestion $quizQuestion)
    {
        abort_if(Gate::denies('quiz_question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizQuestion->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
