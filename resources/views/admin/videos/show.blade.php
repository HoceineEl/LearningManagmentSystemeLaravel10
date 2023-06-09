@extends('layouts.frontend')


@section('content')
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
<video controls crossorigin playsinline>
    <source type="application/x-mpegURL"
        src=" {{ asset('storage/videos/' . str_replace('.m3u8', '', $video->path) . '/' . $video->path) }}">
</video>
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
