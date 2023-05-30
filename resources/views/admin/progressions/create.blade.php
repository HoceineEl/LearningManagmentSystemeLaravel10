@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.progression.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.progressions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="utilisateur_id">{{ trans('cruds.progression.fields.utilisateur') }}</label>
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
                <span class="help-block">{{ trans('cruds.progression.fields.utilisateur_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lesson_id">{{ trans('cruds.progression.fields.lesson') }}</label>
                <select class="form-control select2 {{ $errors->has('lesson') ? 'is-invalid' : '' }}" name="lesson_id" id="lesson_id" required>
                    @foreach($lessons as $id => $entry)
                        <option value="{{ $id }}" {{ old('lesson_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('lesson'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lesson') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.progression.fields.lesson_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('est_complete') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="est_complete" value="0">
                    <input class="form-check-input" type="checkbox" name="est_complete" id="est_complete" value="1" {{ old('est_complete', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_complete">{{ trans('cruds.progression.fields.est_complete') }}</label>
                </div>
                @if($errors->has('est_complete'))
                    <div class="invalid-feedback">
                        {{ $errors->first('est_complete') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.progression.fields.est_complete_helper') }}</span>
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