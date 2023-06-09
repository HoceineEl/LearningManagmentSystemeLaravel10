<?php

namespace App\Http\Requests;

use App\Models\Quiz;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreQuizRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('quiz_create');
    }

    public function rules()
    {
        return [
            'nom' => [
                'string',
                'required',
            ],
            'lesson_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
