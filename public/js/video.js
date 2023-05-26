$(document).ready(function () {
    var progressInterval;

    function updateProgress() {
        $.ajax({
            url: "{{ route('video-conversion-progress') }}",
            method: "GET",
            success: function (response) {
                var progress = response.progress;
                var currentTask = response.current_task;
                console.log(currentTask);
                updateProgressBar(progress, currentTask);

                // Stop the interval if the progress is 100 and there is no current task
                if (progress === 100 || currentTask === "") {
                    clearInterval(progressInterval);
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    }

    function updateProgressBar(progress, currentTask) {
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
        }
    }

    // Handle the upload button click event
    $("#upload-button").on("click", function () {
        var formData = new FormData($("#upload-form")[0]);

        $.ajax({
            url: "{{ route('videos.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Update the video preview source
                $("#video-source").attr("src", response.videoUrl);
                // Show the video preview container
                $("#video-preview-container").show();
                // Load and play the video
                $("#video-preview")[0].load();
                $("#video-preview")[0].play();
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.log(error);
            },
        });
    });

    // Start the progress update interval after the upload button is clicked
    $("#upload-button").on("click", function () {
        progressInterval = setInterval(updateProgress, 1000);
    });
});
