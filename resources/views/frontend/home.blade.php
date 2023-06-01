@extends('layouts.frontend')

@section('content')
    <style>
        .course-image {
            width: 100%;
            height: 200px;
            /* Adjust the height as desired */
            object-fit: cover;
            /* Ensure the image covers the entire space without distortion */
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="mdk-header-layout__content">

                <div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
                    <div class="mdk-drawer-layout__content page ">

                        <div class="container-fluid page__container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="student-dashboard.html">Home</a></li>
                                <li class="breadcrumb-item active">Courses</li>
                            </ol>
                            <div class="media align-items-center mb-headings">
                                <div class="media-body">
                                    <h1 class="h2">Courses</h1>
                                </div>
                                <div class="media-right">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-white active"><i
                                                class="material-icons">list</i></a>
                                        <a href="#" class="btn btn-white"><i class="material-icons">dashboard</i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="card-columns">
                                @foreach ($courses as $course)
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <h4 class="card-title mb-0"><a
                                                    href="student-take-course.html">{{ $course->nom }}</a></h4>
                                            <div class="rating">
                                                <i class="material-icons">star</i>
                                                <i class="material-icons">star</i>
                                                <i class="material-icons">star</i>
                                                <i class="material-icons">star</i>
                                                <i class="material-icons">star_border</i>
                                            </div>
                                        </div>
                                        <a href="student-take-course.html" style="display: block;">
                                            <img src="{{ $course->cover->getUrl() }}" alt="Card image cap"
                                                class="course-image">
                                        </a>
                                        <div class="card-body">
                                            <small class="text-muted">ADVANCED</small><br>
                                            {!! $course->description !!}<br>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>



                </div>

                <!-- App Settings FAB -->
                <div id="app-settings">
                    <app-settings layout-active="default"
                        :layout-location="{
                            'fixed': 'fixed-student-browse-courses.html',
                            'default': 'student-browse-courses.html'
                        }"
                        sidebar-variant="bg-transparent border-0"></app-settings>
                </div>

            </div>
        </div>
    </div>
@endsection
