@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.lecon.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.lecons.update", [$lecon->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="label">{{ trans('cruds.lecon.fields.label') }}</label>
                            <input class="form-control" type="text" name="label" id="label" value="{{ old('label', $lecon->label) }}" required>
                            @if($errors->has('label'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('label') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lecon.fields.label_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="section_id">{{ trans('cruds.lecon.fields.section') }}</label>
                            <select class="form-control select2" name="section_id" id="section_id" required>
                                @foreach($sections as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('section_id') ? old('section_id') : $lecon->section->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('section'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('section') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lecon.fields.section_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="position">{{ trans('cruds.lecon.fields.position') }}</label>
                            <input class="form-control" type="number" name="position" id="position" value="{{ old('position', $lecon->position) }}" step="1" required>
                            @if($errors->has('position'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('position') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.lecon.fields.position_helper') }}</span>
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