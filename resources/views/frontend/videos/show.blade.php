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
{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>HLS Demo</title>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />
    <style>
        body {
            max-width: 1024px;
        }
    </style>
</head>

<body>
    <div class="container">
        <video controls crossorigin playsinline>
            <source type="application/x-mpegURL"
                src="{{ asset('storage/videos/6472094d335bc_input2_Trim/6472094d335bc_input2_Trim.m3u8') }}">
        </video>
    </div>
    <script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
    <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const video = document.querySelector("video");
            const source = video.getElementsByTagName("source")[0].src;

            // For more options see: https://github.com/sampotts/plyr/#options
            const defaultOptions = {};

            if (Hls.isSupported()) {
                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                const hls = new Hls();
                hls.loadSource(source);

                // From the m3u8 playlist, hls parses the manifest and returns
                // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                    // Transform available levels into an array of integers (height values).
                    const availableQualities = hls.levels.map((l) => l.height)

                    // Add new qualities to option
                    defaultOptions.quality = {
                        default: availableQualities[0],
                        options: availableQualities,
                        // this ensures Plyr to use Hls to update quality level
                        // Ref: https://github.com/sampotts/plyr/blob/master/src/js/html5.js#L77
                        forced: true,
                        onChange: (e) => updateQuality(e),
                    }

                    // Initialize new Plyr player with quality options
                    const player = new Plyr(video, defaultOptions);
                });
                hls.attachMedia(video);
                window.hls = hls;
            } else {
                // default options with no quality update in case Hls is not supported
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
</body>

</html> --}}
