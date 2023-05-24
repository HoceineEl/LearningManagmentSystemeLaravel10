@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.utilisateurReponse.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.utilisateur-reponses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.utilisateurReponse.fields.id') }}
                        </th>
                        <td>
                            {{ $utilisateurReponse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.utilisateurReponse.fields.utilisateur') }}
                        </th>
                        <td>
                            {{ $utilisateurReponse->utilisateur->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.utilisateurReponse.fields.reponse') }}
                        </th>
                        <td>
                            {{ $utilisateurReponse->reponse->reponse ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.utilisateurReponse.fields.created_at') }}
                        </th>
                        <td>
                            {{ $utilisateurReponse->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.utilisateur-reponses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection