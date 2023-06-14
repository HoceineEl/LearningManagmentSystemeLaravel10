@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @if ($video)
                    <div class="video-player-container">
                        <video controls crossorigin playsinline>
                            <source type="application/x-mpegURL"
                                src="{{ asset('storage/videos/' . str_replace('.m3u8', '', $video->path) . '/' . $video->path) }}">
                        </video>
                    </div>
                @else
                    <div class="text-center">
                        <p>No video available for this lesson.</p>
                    </div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="d-flex justify-content-between position-sticky bottom-0">
                    @if ($previousLesson)
                        <a href="{{ route('frontend.lesson.show', ['lesson' => $previousLesson]) }}"
                            class="btn btn-primary me-2">Previous Lesson</a>
                    @endif
                    @if ($nextLesson)
                        <a href="{{ route('frontend.lesson.show', ['lesson' => $nextLesson]) }}"
                            class="btn btn-primary">Next Lesson</a>
                    @endif
                </div>
            </div>
        </div>
        @if ($lesson->lessonQuizzes->isNotEmpty())
            <div class="position-fixed top-0 end-0 p-3">
                <a href="{{ url('frontend/quiz/take/' . $lesson->id) }}" class="btn btn-success">Take Lesson Quiz</a>
            </div>
        @endif
    </div>
@section('scripts')
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <style>
        /* Custom styles for the video player container */
        .plyr {
            max-width: 100%;
            height: auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
@endsection
<script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const video = document.querySelector("video");
        const source = video.getElementsByTagName("source")[0].src;

        const defaultOptions = {};

        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(source);
            hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {
                const availableQualities = hls.levels.map((l) => l.height)

                defaultOptions.quality = {
                    default: availableQualities[0],
                    options: availableQualities,
                    forced: true,
                    onChange: (e) => updateQuality(e),
                }
                const player = new Plyr(video, defaultOptions);
            });
            hls.attachMedia(video);
            window.hls = hls;
        } else {
            const player = new Plyr(video, defaultOptions);
        }

        function updateQuality(newQuality) {
            window.hls.levels.forEach((level, levelIndex) => {
                if (level.height === newQuality) {
                    console.log("Found quality match with " + newQuality);
                    window.hls.currentLevel = levelIndex;
                }
            });
        }
    });
</script>
@endsection
