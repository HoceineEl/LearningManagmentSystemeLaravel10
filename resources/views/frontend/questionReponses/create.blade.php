@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.questionReponse.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.question-reponses.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="question_id">{{ trans('cruds.questionReponse.fields.question') }}</label>
                            <select class="form-control select2" name="question_id" id="question_id" required>
                                @foreach($questions as $id => $entry)
                                    <option value="{{ $id }}" {{ old('question_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('question'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('question') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.questionReponse.fields.question_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="reponse">{{ trans('cruds.questionReponse.fields.reponse') }}</label>
                            <input class="form-control" type="text" name="reponse" id="reponse" value="{{ old('reponse', '') }}" required>
                            @if($errors->has('reponse'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reponse') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.questionReponse.fields.reponse_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="est_correct" value="0">
                                <input type="checkbox" name="est_correct" id="est_correct" value="1" {{ old('est_correct', 0) == 1 ? 'checked' : '' }}>
                                <label for="est_correct">{{ trans('cruds.questionReponse.fields.est_correct') }}</label>
                            </div>
                            @if($errors->has('est_correct'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('est_correct') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.questionReponse.fields.est_correct_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection