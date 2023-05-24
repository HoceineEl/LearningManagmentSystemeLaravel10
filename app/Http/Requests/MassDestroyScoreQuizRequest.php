<?php

namespace App\Http\Requests;

use App\Models\ScoreQuiz;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyScoreQuizRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('score_quiz_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:score_quizzes,id',
        ];
    }
}
