<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLeconRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('lesson_create');
    }

    public function rules()
    {
        return [
            'label' => [
                'string',
                'required',
            ],
            'section_id' => [
                'required',
                'integer',
            ],
            'position' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
