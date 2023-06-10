@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.questionReponse.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.question-reponses.update", [$questionReponse->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- <div class="form-group">
                <label class="required" for="question_id">{{ trans('cruds.questionReponse.fields.question') }}</label>
                <select class="form-control select2 {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question_id" id="question_id" required>
                    @foreach($questions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('question_id') ? old('question_id') : $questionReponse->question->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('question'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionReponse.fields.question_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label class="required" for="reponse">{{ trans('cruds.questionReponse.fields.reponse') }}</label>
                <input class="form-control {{ $errors->has('reponse') ? 'is-invalid' : '' }}" type="text" name="reponse" id="reponse" value="{{ old('reponse', $questionReponse->reponse) }}" required>
                @if($errors->has('reponse'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reponse') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionReponse.fields.reponse_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('est_correct') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="est_correct" value="0">
                    <input class="form-check-input" type="checkbox" name="est_correct" id="est_correct" value="1" {{ $questionReponse->est_correct || old('est_correct', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_correct">{{ trans('cruds.questionReponse.fields.est_correct') }}</label>
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



@endsection