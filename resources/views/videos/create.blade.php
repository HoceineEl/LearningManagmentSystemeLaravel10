@extends('videos.layout')

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
        <form enctype="multipart/form-data" id="upload-form">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">Video</label>
                <input type="file" class="filepond" name="video" multiple data-allow-reorder="true"
                    data-max-file-size="20MB" data-max-files="3">
                <div class="progress-wrapper watermark-progress completed-progress">
                    <div class="progress-bar"></div>
                    <div class="progress-text"></div>
                </div>
                <div class="progress-wrapper demo-progress completed-progress">
                    <div class="progress-bar"></div>
                    <div class="progress-text"></div>
                </div>
                <div class="progress-wrapper hls-progress completed-progress">
                    <div class="progress-bar"></div>
                    <div class="progress-text"></div>
                </div>
                <div id="done-animation" class="done-animation" style="display: none;">
                    <strong>Done!</strong> All tasks completed successfully.
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="upload-button">Upload</button>
        </form>
        <div id="video-preview-container" style="display: none;">
            <h2>Uploaded Video Preview</h2>
            <video id="video-preview" class="video-preview" controls>
                <source id="video-source" src="" type="video/mp4">
            </video>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <!-- Include FilePond JavaScript -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <!-- Additional plugins may be required to handle videos, such as FilePond Plugin File Validate Type -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script>
        // First, register any necessary plugins
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        // Then, turn your input element into a pond
        const inputElement = document.querySelector('input.filepond');
        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['video/mp4', 'video/webm', 'video/ogg'],
            labelIdle: 'Drag and drop your files or <span class="filepond--label-action">Browse</span>',
            server: {
                url: "{{ route('videos.store') }}",
                method: 'POST'
            }
        });

        // Listen for the 'submit' event on the form
        document.querySelector("#upload-form").addEventListener('submit', function(event) {
            // Prevent form submission if all fields are not valid
            if (!event.target.checkValidity()) {
                event.preventDefault();
                alert('Please fill in all fields correctly.');
            }
        });
    </script>
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
                        if (progress === 100 && currentTask === null) {
                            clearInterval(progressInterval);
                        }
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
                if (progress === 100 && currentTask === null) {
                    progressWrapper.hide();
                    doneAnimation.show();
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

            // Handle the upload button click event
            $("#upload-button").on("click", function() {
                // Submit the form via AJAX when the upload button is clicked
                $("#upload-form").ajaxSubmit({
                    url: "{{ route('videos.store') }}",
                    type: "POST",
                    dataType: "json",
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
                // Start the progress update interval after the upload button is clicked
                progressInterval = setInterval(updateProgress, 1000);
            });
        });
    </script>

@endsection
