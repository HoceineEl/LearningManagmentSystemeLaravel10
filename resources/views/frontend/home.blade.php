@extends('layouts.frontend')

@section('content')
    <style>
        .course-image-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .course-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .course-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            border-radius: 20px;
        }

        .course-overlay:hover {
            opacity: 1;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 0 0 20px 20px;
        }

        .card-title {
            margin-bottom: 0;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .rating {
            color: #FFC107;
            font-size: 18px;
            margin-top: 10px;
        }

        .card-body {
            padding: 20px;
        }

        .text-muted {
            color: #777;
            font-size: 14px;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .breadcrumb-item {
            display: inline-block;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            vertical-align: middle;
            color: #777;
            margin: 0 5px;
        }
    </style>

    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="student-dashboard.html">Home</a></li>
            <li class="breadcrumb-item active">Courses</li>
        </ol>

        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card rounded-4">
                        <div class="course-image-container">
                            <a href="{{ route('frontend.cours.show', ['cour' => $course->id]) }}">
                                @if (!($course->cover == null))
                                    <img src="{{ $course->cover->getUrl() }}" alt="Course Cover" class="course-image">
                                @else
                                    <img src="{{ asset("assets/online-course-500x333-3420656067.jpeg") }}" alt="Default Course Cover" class="course-image">
                                @endif
                                <div class="course-overlay">
                                    <h5 class="course-title">{{ $course->nom }}</h5>
                                </div>
                            </a>
                        </div>
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-center">{{ $course->nom }}</h4>
                            <div class="rating">
                                @php
                                    $rating = mt_rand(20, 42) / 10;
                                @endphp
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($rating > $i)
                                        <i class="material-icons">star</i>
                                    @else
                                        <i class="material-icons">star_border</i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="card-body">
                            <small class="text-muted">ADVANCED</small><br>
                            {!! $course->description !!}<br>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
