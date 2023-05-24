@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.utilisateurReponse.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.utilisateur-reponses.update", [$utilisateurReponse->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="utilisateur_id">{{ trans('cruds.utilisateurReponse.fields.utilisateur') }}</label>
                            <select class="form-control select2" name="utilisateur_id" id="utilisateur_id" required>
                                @foreach($utilisateurs as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('utilisateur_id') ? old('utilisateur_id') : $utilisateurReponse->utilisateur->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('utilisateur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('utilisateur') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.utilisateurReponse.fields.utilisateur_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="reponse_id">{{ trans('cruds.utilisateurReponse.fields.reponse') }}</label>
                            <select class="form-control select2" name="reponse_id" id="reponse_id" required>
                                @foreach($reponses as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('reponse_id') ? old('reponse_id') : $utilisateurReponse->reponse->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('reponse'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reponse') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.utilisateurReponse.fields.reponse_helper') }}</span>
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