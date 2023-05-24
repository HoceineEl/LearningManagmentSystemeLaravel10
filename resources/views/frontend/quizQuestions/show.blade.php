@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.quizQuestion.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.quiz-questions.index') }}">
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
                            <a class="btn btn-default" href="{{ route('frontend.quiz-questions.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection