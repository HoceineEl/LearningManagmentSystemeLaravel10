@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.video.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.videos.update", [$video->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="video">{{ trans('cruds.video.fields.video') }}</label>
                            <div class="needsclick dropzone" id="video-dropzone">
                            </div>
                            @if($errors->has('video'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('video') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.video.fields.video_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="miniature">{{ trans('cruds.video.fields.miniature') }}</label>
                            <div class="needsclick dropzone" id="miniature-dropzone">
                            </div>
                            @if($errors->has('miniature'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('miniature') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.video.fields.miniature_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="contenu_id">{{ trans('cruds.video.fields.contenu') }}</label>
                            <select class="form-control select2" name="contenu_id" id="contenu_id" required>
                                @foreach($contenus as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('contenu_id') ? old('contenu_id') : $video->contenu->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('contenu'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contenu') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.video.fields.contenu_helper') }}</span>
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
    Dropzone.options.videoDropzone = {
    url: '{{ route('frontend.videos.storeMedia') }}',
    maxFilesize: 2000, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2000
    },
    success: function (file, response) {
      $('form').find('input[name="video"]').remove()
      $('form').append('<input type="hidden" name="video" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="video"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($video) && $video->video)
      var file = {!! json_encode($video->video) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="video" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    Dropzone.options.miniatureDropzone = {
    url: '{{ route('frontend.videos.storeMedia') }}',
    maxFilesize: 100, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="miniature"]').remove()
      $('form').append('<input type="hidden" name="miniature" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="miniature"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($video) && $video->miniature)
      var file = {!! json_encode($video->miniature) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="miniature" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection