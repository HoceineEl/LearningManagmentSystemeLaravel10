@extends('layouts.admin')

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
                                            src="{{ asset('storage/videos/' . str_replace('.m3u8', '', $video->path) . '/demo.mp4') }}"
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
                            @php
                                $hours = floor($video->duration / 3600);
                                $minutes = floor(($video->duration % 3600) / 60);
                                $seconds = $video->duration % 60;
                                
                                // Format values with leading zeros if needed
                                $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                                $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                                $formattedSeconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
                            @endphp

                            {{-- <p class="card-text fw-bold">{{ $video->lecon->label }}</p> --}}
                            <p class="card-text">{{ $formattedHours }}:{{ $formattedMinutes }}:{{ $formattedSeconds }}</p>



                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
