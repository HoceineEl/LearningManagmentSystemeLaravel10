@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.questionReponse.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.question-reponses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.questionReponse.fields.id') }}
                        </th>
                        <td>
                            {{ $questionReponse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionReponse.fields.question') }}
                        </th>
                        <td>
                            {{ $questionReponse->question->question ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionReponse.fields.reponse') }}
                        </th>
                        <td>
                            {{ $questionReponse->reponse }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionReponse.fields.est_correct') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $questionReponse->est_correct ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.question-reponses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#reponse_utilisateur_reponses" role="tab" data-toggle="tab">
                {{ trans('cruds.utilisateurReponse.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="reponse_utilisateur_reponses">
            @includeIf('admin.questionReponses.relationships.reponseUtilisateurReponses', ['utilisateurReponses' => $questionReponse->reponseUtilisateurReponses])
        </div>
    </div>
</div>

@endsection