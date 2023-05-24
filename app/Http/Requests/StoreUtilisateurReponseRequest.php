<?php

namespace App\Http\Requests;

use App\Models\UtilisateurReponse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUtilisateurReponseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('utilisateur_reponse_create');
    }

    public function rules()
    {
        return [
            'utilisateur_id' => [
                'required',
                'integer',
            ],
            'reponse_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
