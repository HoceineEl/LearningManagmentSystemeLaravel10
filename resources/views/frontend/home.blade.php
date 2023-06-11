@extends('layouts.frontend')

@section('content')
    <style>
        .course-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
    </style>

    <div class="container">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="student-dashboard.html">Home</a></li>
            <li class="breadcrumb-item active">Courses</li>
        </ol>

        <div class="clearfix"></div>
        <div class="card-columns ">
            @foreach ($courses as $course)
                <div class="card " style="border-radius: 20px;">
                    <div class="card-header text-center rounded-5">
                        <h4 class="card-title mb-0"><a
                                href="{{ route('frontend.cours.show', ['cour' => $course->id]) }}">{{ $course->nom }}</a>
                        </h4>
                        <div class="rating">
                            <i class="material-icons">star</i>
                            <i class="material-icons">star</i>
                            <i class="material-icons">star</i>
                            <i class="material-icons">star</i>
                            <i class="material-icons">star_border</i>
                        </div>
                    </div>
                    <a href="{{ route('frontend.cours.show', ['cour' => $course->id]) }}" style="display: block;">
                        @if(!($course->cover == null))
                            <img src="{{ $course->cover->getUrl() }}" alt="Card image cap" class="course-image">
                        @else
                            <img src="{{ asset("assets/online-course-500x333-3420656067.jpeg")}}" alt="Card image cap" style="width: 100%">
                        @endif
                    </a>
                    <div class="card-body">
                        <small class="text-muted">ADVANCED</small><br>
                        {!! $course->description !!}<br>
                    </div>
                </div>
            @endforeach

        </div>


    </div>
@endsection