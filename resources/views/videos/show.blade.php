@extends('layout')

@section('content')
    @push('scripts')
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
    @endpush
    <div class="container">
        <video controls crossorigin playsinline poster="https://bitdash-a.akamaihd.net/content/sintel/poster.png"></video>
    </div>
    <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const source =
                "{{ asset('storage/videos/' . str_replace('_0_1500.m3u8', '', $video->path) . '/' . $video->path) }}"
            const video = document.querySelector('video');

            const defaultOptions = {};

            if (!Hls.isSupported()) {
                video.src = source;
                var player = new Plyr(video, defaultOptions);
            } else {
                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                const hls = new Hls();
                hls.loadSource(source);

                // From the m3u8 playlist, hls parses the manifest and returns
                // all available video qualities. This is important, in this approach,
                // we will have one source on the Plyr player.
                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {

                    // Transform available levels into an array of integers (height values).
                    const availableQualities = hls.levels.map((l) => l.height)
                    availableQualities.unshift(0) //prepend 0 to quality array

                    // Add new qualities to option
                    defaultOptions.quality = {
                        default: 0, //Default - AUTO
                        options: availableQualities,
                        forced: true,
                        onChange: (e) => updateQuality(e),
                    }
                    // Add Auto Label 
                    defaultOptions.i18n = {
                        qualityLabel: {
                            0: 'Auto',
                        },
                    }

                    hls.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                        var span = document.querySelector(
                            ".plyr__menu__container [data-plyr='quality'][value='0'] span")
                        if (hls.autoLevelEnabled) {
                            span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                        } else {
                            span.innerHTML = `AUTO`
                        }
                    })

                    // Initialize new Plyr player with quality options
                    var player = new Plyr(video, defaultOptions);
                });

                hls.attachMedia(video);
                window.hls = hls;
            }

            function updateQuality(newQuality) {
                if (newQuality === 0) {
                    window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
                } else {
                    window.hls.levels.forEach((level, levelIndex) => {
                        if (level.height === newQuality) {
                            console.log("Found quality match with " + newQuality);
                            window.hls.currentLevel = levelIndex;
                        }
                    });
                }
            }
        });
    </script>
@endsection
