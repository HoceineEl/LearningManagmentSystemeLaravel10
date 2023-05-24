@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.section.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sections.update", [$section->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="label">{{ trans('cruds.section.fields.label') }}</label>
                <input class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}" type="text" name="label" id="label" value="{{ old('label', $section->label) }}" required>
                @if($errors->has('label'))
                    <div class="invalid-feedback">
                        {{ $errors->first('label') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.label_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="cours_id">{{ trans('cruds.section.fields.cours') }}</label>
                <select class="form-control select2 {{ $errors->has('cours') ? 'is-invalid' : '' }}" name="cours_id" id="cours_id" required>
                    @foreach($cours as $id => $entry)
                        <option value="{{ $id }}" {{ (old('cours_id') ? old('cours_id') : $section->cours->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('cours'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cours') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.cours_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="position">{{ trans('cruds.section.fields.position') }}</label>
                <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="number" name="position" id="position" value="{{ old('position', $section->position) }}" step="1" required>
                @if($errors->has('position'))
                    <div class="invalid-feedback">
                        {{ $errors->first('position') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.position_helper') }}</span>
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