@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.lesson.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.lessons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.lesson.fields.id') }}
                        </th>
                        <td>
                            {{ $lesson->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lesson.fields.label') }}
                        </th>
                        <td>
                            {{ $lesson->label }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lesson.fields.section') }}
                        </th>
                        <td>
                            {{ $lesson->section->label ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lesson.fields.position') }}
                        </th>
                        <td>
                            {{ $lesson->position }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.lessons.index') }}">
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
            <a class="nav-link" href="#lesson_quizzes" role="tab" data-toggle="tab">
                {{ trans('cruds.quiz.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lesson_score_quizzes" role="tab" data-toggle="tab">
                {{ trans('cruds.scoreQuiz.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lesson_progressions" role="tab" data-toggle="tab">
                {{ trans('cruds.progression.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lesson_commentaires" role="tab" data-toggle="tab">
                {{ trans('cruds.commentaire.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#lesson_contenus" role="tab" data-toggle="tab">
                {{ trans('cruds.contenu.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="lesson_quizzes">
            @includeIf('admin.lessons.relationships.lessonQuizzes', ['quizzes' => $lesson->lessonQuizzes])
        </div>
        <div class="tab-pane" role="tabpanel" id="lesson_score_quizzes">
            @includeIf('admin.lessons.relationships.lessonScoreQuizzes', ['scoreQuizzes' => $lesson->lessonScoreQuizzes])
        </div>
        <div class="tab-pane" role="tabpanel" id="lesson_progressions">
            @includeIf('admin.lessons.relationships.lessonProgressions', ['progressions' => $lesson->lessonProgressions])
        </div>
        <div class="tab-pane" role="tabpanel" id="lesson_commentaires">
            @includeIf('admin.lessons.relationships.lessonCommentaires', ['commentaires' => $lesson->lessonCommentaires])
        </div>
        <div class="tab-pane" role="tabpanel" id="lesson_contenus">
            @includeIf('admin.lessons.relationships.lessonContenus', ['contenus' => $lesson->lessonContenus])
        </div>
    </div>
</div>

@endsection