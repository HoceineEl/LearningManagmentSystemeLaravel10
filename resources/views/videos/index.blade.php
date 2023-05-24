@extends('layout')

@section('content')
    <div class="row">
        @foreach ($videos as $video)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        @if ($video->path)
                            <a href="{{ route('videos.show', $video->id) }}">
                                <div class="ratio ratio-16x9">
                                    <video id="video-{{ $video->id }}" autoplay muted loop preload="auto">
                                        <source
                                            src="{{ asset('storage/videos/' . str_replace('_0_1500.m3u8', '', $video->path) . '/demo.mp4') }}"
                                            type="video/mp4">
                                    </video>
                                </div>
                            </a>
                        @else
                            <h1>
                                <i class="fas fa-video-camera fa-2x"></i>
                                <span class="d-none d-md-block">
                                    No video found
                                </span>
                            </h1>
                        @endif
                        <div class="card-footer">
                            <h5 class="card-title">{{ $video->title }}</h5>
                            <p class="card-text" id="duration-{{ $video->id }}"></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection