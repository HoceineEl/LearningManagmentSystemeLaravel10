@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.commentaire.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.commentaires.update", [$commentaire->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="lecon_id">{{ trans('cruds.commentaire.fields.lecon') }}</label>
                            <select class="form-control select2" name="lecon_id" id="lecon_id" required>
                                @foreach($lecons as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('lecon_id') ? old('lecon_id') : $commentaire->lecon->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('lecon'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('lecon') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commentaire.fields.lecon_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="utilisateur_id">{{ trans('cruds.commentaire.fields.utilisateur') }}</label>
                            <select class="form-control select2" name="utilisateur_id" id="utilisateur_id" required>
                                @foreach($utilisateurs as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('utilisateur_id') ? old('utilisateur_id') : $commentaire->utilisateur->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('utilisateur'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('utilisateur') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commentaire.fields.utilisateur_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="commentaire">{{ trans('cruds.commentaire.fields.commentaire') }}</label>
                            <textarea class="form-control ckeditor" name="commentaire" id="commentaire">{!! old('commentaire', $commentaire->commentaire) !!}</textarea>
                            @if($errors->has('commentaire'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('commentaire') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commentaire.fields.commentaire_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('frontend.commentaires.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $commentaire->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection