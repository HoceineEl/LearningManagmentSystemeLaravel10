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
    @endpush
{{-- 
    <style>
        /* Custom styles for the video ratio container */
        .ratio-container {
            position: relative;
            width: 100%;
            padding-top: var(--aspect-ratio);
        }

        /* Custom styles for the video player */
        .ratio-container .plyr {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style> --}}

    <div class="container">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="card video-card">
                    <div class="card-body">

                        <div class="ratio-container ratio-16x9">
                            <video class="plyr" controls crossorigin playsinline>
                                @foreach ($resolutions as $resolution)
                                    <source src="{{ asset('storage/videos/' . $resolution->path) }}" type="video/webm"
                                        size="{{ $resolution->resolution }}" />
                                @endforeach
                                <track kind="captions" label="English" srclang="en"
                                    src="{{ asset('captions/Laravel in 100 Seconds.vtt') }}" default />
                                <track kind="captions" label="Français" srclang="fr"
                                    src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.fr.vtt" />
                            </video>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const players = Array.from(document.querySelectorAll('.plyr'));
            players.forEach(player => {
                new Plyr(player, {
                    captions: {
                        active: true,
                        update: true,
                        language: 'en'
                    },
                    quality: {
                        default: 1080,
                        options: [
                            @foreach ($resolutions as $resolution)
                                {{ $resolution->resolution }},
                            @endforeach
                        ] // Add all the available resolutions here
                    }
                });
            });
        });
    </script>
@endsection
