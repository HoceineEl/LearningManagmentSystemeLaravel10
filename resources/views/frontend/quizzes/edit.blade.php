@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.quiz.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.quizzes.update", [$quiz->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="nom">{{ trans('cruds.quiz.fields.nom') }}</label>
                            <input class="form-control" type="text" name="nom" id="nom" value="{{ old('nom', $quiz->nom) }}" required>
                            @if($errors->has('nom'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nom') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.quiz.fields.nom_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="lecon_id">{{ trans('cruds.quiz.fields.lecon') }}</label>
                            <select class="form-control select2" name="lecon_id" id="lecon_id" required>
                                @foreach($lecons as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('lecon_id') ? old('lecon_id') : $quiz->lecon->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('lecon'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('lecon') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.quiz.fields.lecon_helper') }}</span>
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