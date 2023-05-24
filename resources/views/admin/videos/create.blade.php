@extends('layout')

@section('content')
    <style>
        .progress {
            height: 30px;
            color: #b6c9df;
            font-weight: bold;
        }

        .progress-bar.task1 {
            background-color: #2a70c0;
        }

        .progress-bar.task2 {
            background-color: #42c422;
        }

        .progress-bar.task3 {
            background-color: #c06e2a;
        }

        .progress-bar.task4 {
            background-color: #c81ed8;
        }

        .card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #2a70c0;
            border-color: #2a70c0;
        }

        .btn-primary:hover {
            background-color: #1b4c8b;
            border-color: #1b4c8b;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }
    </style>
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
                <label for="video" class="form-label">Video</label>
                <input type="file" class="form-control-file" id="video" name="video" required>
                <div class="progress mt-2" style="display: none;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <span id="current-task"></span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
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

                        updateProgressBar(progress, currentTask);
                        updateCurrentTask(currentTask);

                        // Stop the interval if the progress is 100 and there is no current task
                        if (progress === 100 || currentTask === '') {
                            clearInterval(progressInterval);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

            function updateProgressBar(progress, currentTask) {
                var progressBar = $('.progress-bar');

                // Stop the animation if the progress is 100 or there is no current task
                if (currentTask === '') {
                    progressBar.stop();
                } else {
                    progressBar.animate({
                        width: progress + '%'
                    }, 500).attr('aria-valuenow', progress);
                }

                // Show the progress bar if it was hidden
                if (progress > 0 && progress < 100) {
                    progressBar.parent('.progress').show();
                } else {
                    progressBar.parent('.progress').hide();
                }
            }

            function updateCurrentTask(currentTask) {
                var currentTaskElement = $('#current-task');

                currentTaskElement.text(currentTask);

                // Assign different CSS class to progress bar based on the current task
                var progressBar = $('.progress-bar');
                progressBar.removeClass().addClass('progress-bar ' + getTaskCSSClass(currentTask));
            }

            function getTaskCSSClass(task) {
                // Define your task-to-CSS-class mapping here
                switch (task) {
                    case 'Watermarking':
                        return 'task1';
                    case 'Demo creation':
                        return 'task2';
                    case 'HLS conversion':
                        return 'task3';
                    case 'Uploading':
                        return 'task4';
                        // Add more cases for additional tasks
                    default:
                        return '';
                }
            }

            // Start the progress update interval
            progressInterval = setInterval(updateProgress, 1000);

            // Show the progress bar on file selection
            $('#video').on('change', function() {
                $('.progress').show();
            });
        });
    </script>
@endsection
