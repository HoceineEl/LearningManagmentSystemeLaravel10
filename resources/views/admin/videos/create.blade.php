@extends('admin.videos.layout')

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
        <h1>Video Upload Form</h1>
        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">lecon</label>
                <select class="form-select form-select-lg" name="lecon_id" id="">
                    <option selected value="1">Routes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="video" class="form-label">Video</label>
                <input id="video" name="video" type="file" class="file" data-show-upload="false"
                    data-show-caption="true" data-msg-placeholder="Select {videos} for upload...">
            </div>
            <div class="mb-3">
                <div class="progress-wrapper watermark-progress completed-progress">
                    <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated"></div>
                    <div class="progress-text fw-bold "></div>
                </div>
                <div class="progress-wrapper demo-progress completed-progress">
                    <div class="progress-bar progress-bar-striped bg-info progress-bar-animated"></div>
                    <div class="progress-text fw-bold"></div>
                </div>
                <div class="progress-wrapper hls-progress completed-progress">
                    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated"></div>
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

            function updateProgress() {
                $.ajax({
                    url: "{{ route('video-conversion-progress') }}",
                    method: "GET",
                    success: function(response) {
                        var progress = response.progress;
                        var currentTask = response.current_task;
                        console.log(currentTask);
                        updateProgressBar(progress, currentTask);

                        // Stop the interval if the progress is 100 and there is no current task

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }

            function updateProgressBar(progress, currentTask) {
                var progressWrapper = $(".progress-wrapper");
                var doneAnimation = $("#done-animation");

                // Hide the progress bars and show the "Done" animation when progress is 100 and there is no current task
                if (currentTask === '' && progress == 404) {
                    progressWrapper.hide();
                    doneAnimation.show();
                    showUploadButton();
                    clearInterval(progressInterval);
                } else {
                    doneAnimation.hide();
                    var progressBar;
                    var progressText;

                    switch (currentTask) {
                        case "Watermarking":
                            progressBar = $(".watermark-progress .progress-bar");
                            progressText = $(".watermark-progress .progress-text");
                            break;
                        case "Demo creation":
                            progressBar = $(".demo-progress .progress-bar");
                            progressText = $(".demo-progress .progress-text");
                            break;
                        case "HLS conversion":
                            progressBar = $(".hls-progress .progress-bar");
                            progressText = $(".hls-progress .progress-text");
                            break;
                        default:
                            return;
                    }

                    progressText.text(currentTask + ": " + progress + "%");

                    // Show the progress bar if it was hidden and there is progress
                    if (progress > 0 && progress <= 100) {
                        progressBar.css("width", progress + "%");
                        progressBar.parent(".progress-wrapper").show();
                    } else {
                        progressBar.css("width", 0 + "%");
                    }
                }
            }
            var uploadButton = $("#upload-button");
            var uploadSpinner = $(".spinner-border");
            var uploadingText = $(".visually-hidden:contains('Uploading...')");
            var uploadText = $(".upload");

            function showUploadButton() {
                uploadSpinner.addClass("visually-hidden");
                uploadingText.addClass("visually-hidden");
                uploadText.removeClass("visually-hidden");
            }

            // Handle the upload button click event
            $("#upload-button").on("click", function() {
                uploadSpinner.removeClass("visually-hidden");
                uploadingText.removeClass("visually-hidden");
                uploadText.addClass("visually-hidden");
                var formData = new FormData($("#upload-form")[0]);

                $.ajax({
                    url: "{{ route('videos.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Update the video preview source
                        $("#video-source").attr("src", response.videoUrl);
                        // Show the video preview container
                        $("#video-preview-container").show();
                        // Load and play the video
                        $("#video-preview")[0].load();
                        $("#video-preview")[0].play();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.log(error);
                    },
                });
            });

            // Start the progress update interval after the upload button is clicked
            $("#upload-button").on("click", function() {
                progressInterval = setInterval(updateProgress, 1000);
            });
        });
    </script>

@endsection
{{-- $(document).ready(function() {
            var progressInterval;
            var uploadButton = $("#upload-button");
            var uploadSpinner = $(".spinner-border");
            var uploadingText = $(".visually-hidden:contains('Uploading...')");
            var uploadText = $(".upload");

            function updateProgress() {
                $.ajax({
                    url: "{{ route('video-conversion-progress') }}",
                    method: "GET",
                    success: function(response) {
                        var progress = response.progress;
                        var currentTask = response.current_task;
                        updateProgressBar(progress, currentTask);

                        // Stop the interval if the progress is 100 and there is no current task
                        if (progress === 100 && currentTask === null) {
                            clearInterval(progressInterval);
                            showUploadButton();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }

            function updateProgressBar(progress, currentTask) {
                var watermarkProgressWrapper = $(".progress-wrapper.watermark-progress");
                var demoProgressWrapper = $(".progress-wrapper.demo-progress");
                var hlsProgressWrapper = $(".progress-wrapper.hls-progress");
                var doneAnimation = $("#done-animation");

                watermarkProgressWrapper.find(".progress-bar").css("width", progress + "%");
                watermarkProgressWrapper.find(".progress-text").text("Watermarking " + progress + "%");

                demoProgressWrapper.find(".progress-bar").css("width", progress + "%");
                demoProgressWrapper.find(".progress-text").text("Demo creation " + progress + "%");

                hlsProgressWrapper.find(".progress-bar").css("width", progress + "%");
                hlsProgressWrapper.find(".progress-text").text("HLS conversion " + progress + "%");

                // If all tasks are completed (progress is 100 and no current task), show the done animation
                if (progress === 100 && currentTask === null) {
                    doneAnimation.show();
                }
            }

            function showUploadButton() {
                uploadSpinner.addClass("visually-hidden");
                uploadingText.addClass("visually-hidden");
                uploadText.removeClass("visually-hidden");
            }

            // Handle the upload button click event
            uploadButton.on("click", function() {
                uploadSpinner.removeClass("visually-hidden");
                uploadingText.removeClass("visually-hidden");
                uploadText.addClass("visually-hidden");

                var formData = new FormData($("#upload-form")[0]);

                $.ajax({
                    url: "{{ route('videos.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Update the video preview source
                        $("#video-source").attr("src", response.videoUrl);
                        // Show the video preview container
                        $("#video-preview-container").show();
                        // Load and play the video
                        $("#video-preview")[0].load();
                        $("#video-preview")[0].play();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.log(error);
                    },
                });
            });

            // Start the progress update interval after the upload button is clicked
            uploadButton.on("click", function() {
                progressInterval = setInterval(updateProgress, 1000);
            });
         --}}
