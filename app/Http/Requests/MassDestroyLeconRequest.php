<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLeconRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('lecon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:lessons,id',
        ];
    }
}
