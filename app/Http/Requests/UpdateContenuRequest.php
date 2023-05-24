<?php

namespace App\Http\Requests;

use App\Models\Contenu;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateContenuRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contenu_edit');
    }

    public function rules()
    {
        return [
            'lecon_id' => [
                'required',
                'integer',
            ],
            'ordre' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'id_type' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
