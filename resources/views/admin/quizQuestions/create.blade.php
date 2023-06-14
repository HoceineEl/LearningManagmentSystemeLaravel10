@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <label class="" for="quiz_id">{{ $quiz1->nom }}</label>

            {{-- {{ trans('global.create') }} {{ trans('cruds.quizQuestion.title_singular') }} --}}
        </div>

        <div class="card-body">
            <form method="post" action="{{ url('admin/quiz-questions/store/' . $quiz1->id) }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="quiz_id" value="{{ $quiz1->id }}">

                <div class="form-group">
                    <label class="required" for="question">{{ trans('cruds.quizQuestion.fields.question') }}</label>
                    <input class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" type="text"
                        name="question" id="question" value="{{ old('question', '') }}" required>
                    @if ($errors->has('question'))
                        <div class="invalid-feedback">
                            {{ $errors->first('question') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.quizQuestion.fields.question_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="ordre">{{ trans('cruds.quizQuestion.fields.ordre') }}</label>
                    <input class="form-control {{ $errors->has('ordre') ? 'is-invalid' : '' }}" type="number"
                        name="ordre" id="ordre" value="{{ old('ordre', '') }}" step="1" required>
                    @if ($errors->has('ordre'))
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
@endsection
