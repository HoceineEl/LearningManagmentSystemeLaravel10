<?php

namespace App\Http\Requests;

use App\Models\ScoreQuiz;
use  Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateScoreQuizRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('score_quiz_edit');
    }

    public function rules()
    {
        return [
            'lesson_id' => [
                'required',
                'integer',
            ],
            'quiz_id' => [
                'required',
                'integer',
            ],
            'utilisateur_id' => [
                'required',
                'integer',
            ],
            'score' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
