@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.scoreQuiz.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.score-quizzes.update", [$scoreQuiz->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="lecon_id">{{ trans('cruds.scoreQuiz.fields.lecon') }}</label>
                            <select class="form-control select2" name="lecon_id" id="lecon_id" required>
                                @foreach($lecons as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('lecon_id') ? old('lecon_id') : $scoreQuiz->lecon->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('lecon'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('lecon') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.scoreQuiz.fields.lecon_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="quiz_id">{{ trans('cruds.scoreQuiz.fields.quiz') }}</label>
                            <select class="form-control select2" name="quiz_id" id="quiz_id" required>
                                @foreach($quizzes as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('quiz_id') ? old('quiz_id') : $scoreQuiz->quiz->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('quiz'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('quiz') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.scoreQuiz.fields.quiz_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="utilisateur_id">{{ trans('cruds.scoreQuiz.fields.utilisateur') }}</label>
                            <select class="form-control select2" name="utilisateur_id" id="utilisateur_id" required>
                                @foreach($utilisateurs as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('utilisateur_id') ? old('utilisateur_id') : $scoreQuiz->utilisateur->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('utilisateur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('utilisateur') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.scoreQuiz.fields.utilisateur_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="score">{{ trans('cruds.scoreQuiz.fields.score') }}</label>
                            <input class="form-control" type="number" name="score" id="score" value="{{ old('score', $scoreQuiz->score) }}" step="1">
                            @if($errors->has('score'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('score') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.scoreQuiz.fields.score_helper') }}</span>
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