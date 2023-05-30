@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.commentaire.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.commentaires.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="lesson_id">{{ trans('cruds.commentaire.fields.lesson') }}</label>
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
                <span class="help-block">{{ trans('cruds.commentaire.fields.lesson_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="utilisateur_id">{{ trans('cruds.commentaire.fields.utilisateur') }}</label>
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
                <span class="help-block">{{ trans('cruds.commentaire.fields.utilisateur_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="commentaire">{{ trans('cruds.commentaire.fields.commentaire') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('commentaire') ? 'is-invalid' : '' }}" name="commentaire" id="commentaire">{!! old('commentaire') !!}</textarea>
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
                xhr.open('POST', '{{ route('admin.commentaires.storeCKEditorImages') }}', true);
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