@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.questionReponse.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.question-reponses.index') }}">
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
                            <a class="btn btn-default" href="{{ route('frontend.question-reponses.index') }}">
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