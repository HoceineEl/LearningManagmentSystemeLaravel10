@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.lecon.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.lecons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.lecon.fields.id') }}
                        </th>
                        <td>
                            {{ $lecon->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lecon.fields.label') }}
                        </th>
                        <td>
                            {{ $lecon->label }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lecon.fields.section') }}
                        </th>
                        <td>
                            {{ $lecon->section->label ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lecon.fields.position') }}
                        </th>
                        <td>
                            {{ $lecon->position }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.lecons.index') }}">
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
            <a class="nav-link" href="#lecon_quizzes" role="tab" data-toggle="tab">
                {{ trans('cruds.quiz.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lecon_score_quizzes" role="tab" data-toggle="tab">
                {{ trans('cruds.scoreQuiz.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lecon_progressions" role="tab" data-toggle="tab">
                {{ trans('cruds.progression.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lecon_commentaires" role="tab" data-toggle="tab">
                {{ trans('cruds.commentaire.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lecon_contenus" role="tab" data-toggle="tab">
                {{ trans('cruds.contenu.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="lecon_quizzes">
            @includeIf('admin.lecons.relationships.leconQuizzes', ['quizzes' => $lecon->leconQuizzes])
        </div>
        <div class="tab-pane" role="tabpanel" id="lecon_score_quizzes">
            @includeIf('admin.lecons.relationships.leconScoreQuizzes', ['scoreQuizzes' => $lecon->leconScoreQuizzes])
        </div>
        <div class="tab-pane" role="tabpanel" id="lecon_progressions">
            @includeIf('admin.lecons.relationships.leconProgressions', ['progressions' => $lecon->leconProgressions])
        </div>
        <div class="tab-pane" role="tabpanel" id="lecon_commentaires">
            @includeIf('admin.lecons.relationships.leconCommentaires', ['commentaires' => $lecon->leconCommentaires])
        </div>
        <div class="tab-pane" role="tabpanel" id="lecon_contenus">
            @includeIf('admin.lecons.relationships.leconContenus', ['contenus' => $lecon->leconContenus])
        </div>
    </div>
</div>

@endsection