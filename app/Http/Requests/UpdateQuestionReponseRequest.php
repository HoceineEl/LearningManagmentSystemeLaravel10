<?php

namespace App\Http\Requests;

use App\Models\QuestionReponse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQuestionReponseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('question_reponse_edit');
    }

    public function rules()
    {
        return [
            'question_id' => [
                'required',
                'integer',
            ],
            'reponse' => [
                'string',
                'required',
            ],
        ];
    }
}
