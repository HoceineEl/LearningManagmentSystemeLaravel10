@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.scoreQuiz.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.score-quizzes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="lecon_id">{{ trans('cruds.scoreQuiz.fields.lecon') }}</label>
                <select class="form-control select2 {{ $errors->has('lecon') ? 'is-invalid' : '' }}" name="lecon_id" id="lecon_id" required>
                    @foreach($lecons as $id => $entry)
                        <option value="{{ $id }}" {{ old('lecon_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <select class="form-control select2 {{ $errors->has('quiz') ? 'is-invalid' : '' }}" name="quiz_id" id="quiz_id" required>
                    @foreach($quizzes as $id => $entry)
                        <option value="{{ $id }}" {{ old('quiz_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <select class="form-control select2 {{ $errors->has('utilisateur') ? 'is-invalid' : '' }}" name="utilisateur_id" id="utilisateur_id" required>
                    @foreach($utilisateurs as $id => $entry)
                        <option value="{{ $id }}" {{ old('utilisateur_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <input class="form-control {{ $errors->has('score') ? 'is-invalid' : '' }}" type="number" name="score" id="score" value="{{ old('score', '0') }}" step="1">
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



@endsection