@extends('layouts.frontend')

@section('content')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <style>
        /* Custom styles for the video player container */
        .plyr {
            max-width: 100%;
            height: auto;
        }

        .course-image {
            width: 100%;
            height: 100%;
            /* Adjust the height as desired */
            object-fit: cover;
            /* Ensure the image covers the entire space without distortion */
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="student-dashboard.html">Home</a></li>
                <li class="breadcrumb-item active">Courses</li>
            </ol>
            <div class="clearfix"></div>
            <h1 class="h2">{{ $course->nom }}</h1>
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        @if ($video)
                            <video controls crossorigin playsinline>
                                <source type="application/x-mpegURL"
                                    src="{{ asset('storage/videos/' . str_replace('.m3u8', '', $video->path) . '/' . $video->path) }}">
                            </video>
                        @else
                            <img src="{{ $course->cover->getUrl() }}" alt="Card image cap" class="course-image">
                        @endif
                        <div class="card-body">
                            {!! $course->description !!}
                        </div>
                    </div>

                    <!-- Lessons -->
                    <div class="accordion accordion-borderless" id="accordionFlushExampleX">
                        @foreach ($course->sections->sortBy('position') as $section)
                            <div class="accordion-item ">
                                <h2 class="accordion-header" id="flush-heading{{ $section->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $section->id }}" aria-expanded="false"
                                        aria-controls="flush-collapse{{ $section->id }}">
                                        {{ $section->label }}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $section->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="flush-heading{{ $section->id }}"
                                    data-bs-parent="#accordionFlushExampleX">
                                    <div class="accordion-body">
                                        <ul class="lesson-list" data-section-id="{{ $section->id }}">
                                            @foreach ($section->lessons->sortBy('position') as $lesson)
                                                <li class="list-group-item">

                                                    <div class="media">
                                                        <div class="media-left">
                                                            <div class="text-muted">
                                                                {{ $lesson->position }}.
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <a
                                                                href="{{ route('frontend.lesson.show', ['lesson' => $lesson]) }}">{{ $lesson->label }}</a>
                                                        </div>
                                                        <div class="media-right">
                                                            @if ($lesson->videos->first())
                                                                <i
                                                                    class="sidebar-menu-icon sidebar-menu-icon--left material-icons">play_circle_outline</i>
                                                            @else
                                                                <i
                                                                    class="sidebar-menu-icon sidebar-menu-icon--left material-icons">error_outline</i>
                                                            @endif
                                                        </div>

                                                    </div>

                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
                <div class="col-md-4">

                    <div class="card">
                        <div class="card-header">
                            <div class="media align-items-center">
                                <div class="media-left me-2">
                                    <img src="{{ asset('assets/images/people/110/guy-6.jpg') }}"
                                        alt="About {{ $course->auteur->name }}" width="50" class="rounded-circle m-2">
                                </div>
                                <div class="media-body ms-2">
                                    <h4 class="card-title"><a
                                            href="instructor-profile.html">{{ $course->auteur->name }}</a>
                                    </h4>
                                    <p class="card-subtitle"></p>
                                </div>Instructor
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Having over 12 years exp. {{ $course->auteur->name }} is one of the lead
                                backend
                                developers in the industry
                            </p>
                            <a href="" class="btn btn-light"><i class="fab fa-facebook"></i></a>
                            <a href="" class="btn btn-light"><i class="fab fa-twitter"></i></a>
                            <a href="" class="btn btn-light"><i class="fab fa-github"></i></a>
                        </div>
                    </div>

                    <div class="card">
                        <ul class="list-group list-group-fit">
                            <li class="list-group-item">
                                <div class="media align-items-center">
                                    <div class="media-left">
                                        <i class="material-icons text-muted-light">schedule</i>
                                    </div>
                                    <div class="media-body">
                                        2 <small class="text-muted">hrs</small> &nbsp; 26 <small
                                            class="text-muted">min</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="media align-items-center">
                                    <div class="media-left">
                                        <i class="material-icons text-muted-light">assessment</i>
                                    </div>
                                    <div class="media-body">Beginner</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Ratings</h4>
                        </div>
                        <div class="card-body">
                            <div class="rating">
                                <i class="material-icons">star</i>
                                <i class="material-icons">star</i>
                                <i class="material-icons">star</i>
                                <i class="material-icons">star</i>
                                <i class="material-icons">star_border</i>
                            </div>
                            <small class="text-muted">20 ratings</small>
                        </div>
                    </div>

                    <a href="student-help-center.html" class="btn btn-default btn-block">
                        <i class="material-icons btn__icon--left">help</i> Get Help
                    </a>
                </div>
            </div>

        </div>
    </div>


    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
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
