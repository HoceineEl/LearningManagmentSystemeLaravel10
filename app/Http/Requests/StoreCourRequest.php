<?php

namespace App\Http\Requests;

use App\Models\Cour;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCourRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cour_create');
    }

    public function rules()
    {
        return [
            'nom' => [
                'string',
                'required',
                'unique:cours',
            ],
            // 'auteur_id' => [
            //     'required',
            //     'integer',
            // ],
        ];
    }
}
