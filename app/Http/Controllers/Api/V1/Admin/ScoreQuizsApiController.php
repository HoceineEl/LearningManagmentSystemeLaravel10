<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScoreQuizRequest;
use App\Http\Requests\UpdateScoreQuizRequest;
use App\Http\Resources\Admin\ScoreQuizResource;
use App\Models\ScoreQuiz;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScoreQuizsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('score_quiz_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ScoreQuizResource(ScoreQuiz::with(['lesson', 'quiz', 'utilisateur'])->get());
    }

    public function store(StoreScoreQuizRequest $request)
    {
        $scoreQuiz = ScoreQuiz::create($request->all());

        return (new ScoreQuizResource($scoreQuiz))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ScoreQuiz $scoreQuiz)
    {
        abort_if(Gate::denies('score_quiz_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ScoreQuizResource($scoreQuiz->load(['lesson', 'quiz', 'utilisateur']));
    }

    public function update(UpdateScoreQuizRequest $request, ScoreQuiz $scoreQuiz)
    {
        $scoreQuiz->update($request->all());

        return (new ScoreQuizResource($scoreQuiz))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ScoreQuiz $scoreQuiz)
    {
        abort_if(Gate::denies('score_quiz_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scoreQuiz->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
