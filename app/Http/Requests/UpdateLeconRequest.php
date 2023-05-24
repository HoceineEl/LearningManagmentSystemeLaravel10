<?php

namespace App\Http\Requests;

use App\Models\Lecon;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLeconRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('lecon_edit');
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
