<?php

namespace App\Http\Requests;

use App\Models\Progression;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProgressionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('progression_create');
    }

    public function rules()
    {
        return [
            'utilisateur_id' => [
                'required',
                'integer',
            ],
            'lecon_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
