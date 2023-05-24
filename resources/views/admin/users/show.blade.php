@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.verified') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->verified ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.two_factor') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->two_factor ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
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
            <a class="nav-link" href="#auteur_cours" role="tab" data-toggle="tab">
                {{ trans('cruds.cour.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#utilisateur_utilisateur_reponses" role="tab" data-toggle="tab">
                {{ trans('cruds.utilisateurReponse.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#utilisateur_score_quizzes" role="tab" data-toggle="tab">
                {{ trans('cruds.scoreQuiz.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#utilisateur_progressions" role="tab" data-toggle="tab">
                {{ trans('cruds.progression.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#utilisateur_commentaires" role="tab" data-toggle="tab">
                {{ trans('cruds.commentaire.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_alerts" role="tab" data-toggle="tab">
                {{ trans('cruds.userAlert.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="auteur_cours">
            @includeIf('admin.users.relationships.auteurCours', ['cours' => $user->auteurCours])
        </div>
        <div class="tab-pane" role="tabpanel" id="utilisateur_utilisateur_reponses">
            @includeIf('admin.users.relationships.utilisateurUtilisateurReponses', ['utilisateurReponses' => $user->utilisateurUtilisateurReponses])
        </div>
        <div class="tab-pane" role="tabpanel" id="utilisateur_score_quizzes">
            @includeIf('admin.users.relationships.utilisateurScoreQuizzes', ['scoreQuizzes' => $user->utilisateurScoreQuizzes])
        </div>
        <div class="tab-pane" role="tabpanel" id="utilisateur_progressions">
            @includeIf('admin.users.relationships.utilisateurProgressions', ['progressions' => $user->utilisateurProgressions])
        </div>
        <div class="tab-pane" role="tabpanel" id="utilisateur_commentaires">
            @includeIf('admin.users.relationships.utilisateurCommentaires', ['commentaires' => $user->utilisateurCommentaires])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_alerts">
            @includeIf('admin.users.relationships.userUserAlerts', ['userAlerts' => $user->userUserAlerts])
        </div>
    </div>
</div>

@endsection