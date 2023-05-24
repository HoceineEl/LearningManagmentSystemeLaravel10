<?php

namespace App\Http\Requests;

use App\Models\QuestionReponse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQuestionReponseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('question_reponse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:question_reponses,id',
        ];
    }
}
