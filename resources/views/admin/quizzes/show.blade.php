@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.quiz.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quizzes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.quiz.fields.id') }}
                        </th>
                        <td>
                            {{ $quiz->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quiz.fields.nom') }}
                        </th>
                        <td>
                            {{ $quiz->nom }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quiz.fields.lecon') }}
                        </th>
                        <td>
                            {{ $quiz->lecon->label ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quizzes.index') }}">
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
            <a class="nav-link" href="#quiz_quiz_questions" role="tab" data-toggle="tab">
                {{ trans('cruds.quizQuestion.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#quiz_score_quizzes" role="tab" data-toggle="tab">
                {{ trans('cruds.scoreQuiz.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="quiz_quiz_questions">
            @includeIf('admin.quizzes.relationships.quizQuizQuestions', ['quizQuestions' => $quiz->quizQuizQuestions])
        </div>
        <div class="tab-pane" role="tabpanel" id="quiz_score_quizzes">
            @includeIf('admin.quizzes.relationships.quizScoreQuizzes', ['scoreQuizzes' => $quiz->quizScoreQuizzes])
        </div>
    </div>
</div>

@endsection