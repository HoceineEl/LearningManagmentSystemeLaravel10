@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.quizQuestion.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quiz-questions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.quizQuestion.fields.id') }}
                        </th>
                        <td>
                            {{ $quizQuestion->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quizQuestion.fields.quiz') }}
                        </th>
                        <td>
                            {{ $quizQuestion->quiz->nom ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quizQuestion.fields.question') }}
                        </th>
                        <td>
                            {{ $quizQuestion->question }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quizQuestion.fields.ordre') }}
                        </th>
                        <td>
                            {{ $quizQuestion->ordre }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.quiz-questions.index') }}">
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
            <a class="nav-link" href="#question_question_reponses" role="tab" data-toggle="tab">
                {{ trans('cruds.questionReponse.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="question_question_reponses">
            @includeIf('admin.quizQuestions.relationships.questionQuestionReponses', ['questionReponses' => $quizQuestion->questionQuestionReponses])
        </div>
    </div>
</div>

@endsection