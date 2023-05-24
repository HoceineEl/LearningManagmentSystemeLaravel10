<?php

namespace App\Http\Requests;

use App\Models\Cour;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCourRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cour_edit');
    }

    public function rules()
    {
        return [
            'nom' => [
                'string',
                'required',
                'unique:cours,nom,' . request()->route('cour')->id,
            ],
            'auteur_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
