<?php

namespace App\Http\Requests;

use App\Models\Quiz;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQuizRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('quiz_edit');
    }

    public function rules()
    {
        return [
            'nom' => [
                'string',
                'required',
            ],
            'lecon_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
