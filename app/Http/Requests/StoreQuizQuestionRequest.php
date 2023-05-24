<?php

namespace App\Http\Requests;

use App\Models\QuizQuestion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreQuizQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('quiz_question_create');
    }

    public function rules()
    {
        return [
            'quiz_id' => [
                'required',
                'integer',
            ],
            'question' => [
                'string',
                'required',
            ],
            'ordre' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
