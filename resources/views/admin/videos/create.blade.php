@extends('layouts.admin')
@section('styles')
    @include('admin.videos.scripts.scripts')
@endsection
@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-5">
        <h1>Upload Video for {{ $lesson->label }} </h1>
        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
            @csrf
             <input type="hidden" class="form-control" id="title" name="title"
                value="video for lesseon {{ $lesson->label }}">
            <input type="hidden" value="{{ $lesson->id }}" id="lecon_id" name="lecon_id" required>
            <div class="mb-3">
                <label for="video" class="form-label">Video</label>
                <input id="video" name="video" type="file" class="file" data-show-upload="false"
                    data-show-caption="true" data-msg-placeholder="Select {videos} for upload...">
            </div>
            <div class="mb-3">
                <div class="progress-wrapper watermark-progress completed-progress">
                    <div class="progress-bar bg-warning"></div>
                    <div class="progress-text fw-bold"></div>
                </div>
                <div class="progress-wrapper demo-progress completed-progress">
                    <div class="progress-bar bg-info"></div>
                    <div class="progress-text fw-bold"></div>
                </div>
                <div class="progress-wrapper hls-progress completed-progress">
                    <div class="progress-bar bg-success"></div>
                    <div class="progress-text fw-bold"></div>
                </div>
                <div id="done-animation" class="done-animation" style="display: none;">
                    <strong>Done!</strong> All tasks completed successfully.
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="upload-button">
                <span class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
                <span class="visually-hidden">Uploading...</span>
                <span class="upload">Upload</span>
            </button>
        </form>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            var progressInterval;
            var isUploading = false;
            var uploadButton = $("#upload-button");
            var progressWrapper = $(".progress-wrapper");
            var doneAnimation = $("#done-animation");
            var watermarkProgressBar = $(".watermark-progress .progress-bar");
            var demoProgressBar = $(".demo-progress .progress-bar");
            var hlsProgressBar = $(".hls-progress .progress-bar");
            var watermarkProgressText = $(".watermark-progress .progress-text");
            var demoProgressText = $(".demo-progress .progress-text");
            var hlsProgressText = $(".hls-progress .progress-text");

            function updateProgress() {
                if (!isUploading) {
                    $.ajax({
                        url: "{{ route('video-conversion-progress') }}",
                        method: "GET",
                        success: function(response) {
                            var progress = response.progress;
                            var currentTask = response.current_task;
                            console.log(currentTask);
                            updateProgressBar(progress, currentTask);

                            // Stop the interval if the progress is 100 and there is no current task
                            if (progress == 404 && currentTask === '') {
                                clearInterval(progressInterval);
                                showUploadButton();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }
            }

            function updateProgressBar(progress, currentTask) {
                // Hide the progress bars and show the "Done" animation when progress is 100 and there is no current task
                if (currentTask === '' && progress == 404) {
                    progressWrapper.hide();
                    doneAnimation.show();
                } else {
                    doneAnimation.hide();
                    var progressBar;
                    var progressText;

                    switch (currentTask) {
                        case "Watermarking":
                            progressBar = watermarkProgressBar;
                            progressText = watermarkProgressText;
                            break;
                        case "Demo creation":
                            progressBar = demoProgressBar;
                            progressText = demoProgressText;
                            break;
                        case "HLS conversion":
                            progressBar = hlsProgressBar;
                            progressText = hlsProgressText;
                            break;
                        default:
                            return;
                    }

                    progressText.text(currentTask + ": " + progress + "%");

                    // Show the progress bar if there is progress
                    if (progress > 0 && progress <= 100) {
                        progressBar.css("width", progress + "%");
                        progressBar.parent(".progress-wrapper").show();
                    } else {
                        progressBar.css("width", 0 + "%");
                    }
                }
            }

            function clearProgressBar() {
                doneAnimation.hide();
                watermarkProgressBar.css("width", 0 + "%");
                demoProgressBar.css("width", 0 + "%");
                hlsProgressBar.css("width", 0 + "%");
                watermarkProgressText.text('');
                demoProgressText.text('');
                hlsProgressText.text('');

            }

            function showUploadButton() {
                var uploadSpinner = $(".spinner-border");
                var uploadingText = $(".visually-hidden:contains('Uploading...')");
                var uploadText = $(".upload");

                uploadSpinner.addClass("visually-hidden");
                uploadingText.addClass("visually-hidden");
                uploadText.removeClass("visually-hidden");
                uploadButton.removeClass("disabled");
            }

            // Handle the upload button click event
            uploadButton.on("click", function() {
                if (!isUploading) {
                    isUploading = true;
                    var formData = new FormData($("#upload-form")[0]);
                    clearProgressBar();
                    uploadButton.addClass("disabled");
                    progressWrapper.show();

                    $.ajax({
                        url: "{{ route('videos.store') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.log(error);
                        },
                        complete: function() {
                            isUploading = false;
                        }
                    });
                }
            });

            // Start the progress update interval after the upload button is clicked
            uploadButton.on("click", function() {
                progressInterval = setInterval(updateProgress, 2000);
            });
        });
    </script>

@endsection
