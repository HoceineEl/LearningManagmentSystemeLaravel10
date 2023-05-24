@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.quizQuestion.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.quiz-questions.update", [$quizQuestion->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="quiz_id">{{ trans('cruds.quizQuestion.fields.quiz') }}</label>
                            <select class="form-control select2" name="quiz_id" id="quiz_id" required>
                                @foreach($quizzes as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('quiz_id') ? old('quiz_id') : $quizQuestion->quiz->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('quiz'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('quiz') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.quizQuestion.fields.quiz_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="question">{{ trans('cruds.quizQuestion.fields.question') }}</label>
                            <input class="form-control" type="text" name="question" id="question" value="{{ old('question', $quizQuestion->question) }}" required>
                            @if($errors->has('question'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('question') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.quizQuestion.fields.question_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="ordre">{{ trans('cruds.quizQuestion.fields.ordre') }}</label>
                            <input class="form-control" type="number" name="ordre" id="ordre" value="{{ old('ordre', $quizQuestion->ordre) }}" step="1" required>
                            @if($errors->has('ordre'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ordre') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.quizQuestion.fields.ordre_helper') }}</span>
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