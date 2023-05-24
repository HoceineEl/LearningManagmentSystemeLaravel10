<?php

namespace App\Http\Requests;

use App\Models\QuizQuestion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQuizQuestionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quiz_question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:quiz_questions,id',
        ];
    }
}
