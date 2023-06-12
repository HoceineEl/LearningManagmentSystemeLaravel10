<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('assets/vendor/perfect-scrollbar.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/material-icons.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/fontawesome.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/vendor/spinkit.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/fancytree.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css')}}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        integrity="sha512-ZnR2wlLbSbr8/c9AgLg3jQPAattCUImNsae6NHYnS9KrIwRdcY9DxFotXhNAKIKbAXlRnujIqUWoXXwqyFOeIQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="mdk-header-layout js-mdk-header-layout">

        <!-- Header -->
        @include('frontend.partials.header')

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">
            <div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
                <div class="mdk-drawer-layout__content page ">
                    <div class="container-fluid page__container p-0">
                        <div class="row m-0">
                            <div class="col-lg container-fluid page__container">
                                <main class="py-5">
                                    @if (session('message'))
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-success" role="alert">
                                                        {{ session('message') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($errors->count() > 0)
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-danger">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @yield('content')
                                </main>

                            </div>
                        </div>
                    </div>
                </div>
                @if (\Illuminate\Support\Facades\Route::is('frontend.lesson.show'))
                    @include('frontend.partials.lessonsSidebar')

                @endif

            </div>
            <!-- App Settings FAB -->
            <div id="app-settings" class="d-none">
                <app-settings layout-active="default"></app-settings>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>

    <!-- Perfect Scrollbar -->
    <script src="{{ asset('assets/vendor/perfect-scrollbar.min.js') }}"></script>

    <!-- MDK -->
    <script src="{{ asset('assets/vendor/dom-factory.js') }}"></script>
    <script src="{{ asset('assets/vendor/material-design-kit.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Highlight.js -->
    <script src="{{ asset('assets/js/hljs.js') }}"></script>

    <!-- App Settings (safe to remove) -->
    <script src="{{ asset('assets/js/app-settings.js') }}"></script>

    <!-- List.js -->
    <script src="{{ asset('assets/vendor/list.min.js') }}"></script>
    <script src="{{ asset('assets/js/list.js') }}"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            var currentStep = 0;
            var totalSteps = $(".step").length;

            function showStep(stepNumber) {
                $(".step").hide();
                $(".step:eq(" + stepNumber + ")").show();
            }

            function updateButtons() {
                if (currentStep === totalSteps - 1) {
                    $(".next").hide();
                    $(".submit").show();
                } else {
                    $(".next").show();
                    $(".submit").hide();
                }
            }

            updateButtons();

            $(".next").click(function() {
                var $currentStep = $(".step").eq(currentStep);

                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    showStep(currentStep);
                    updateButtons();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".question li").each(function() {
                var isCorrect = $(this).hasClass("correct");
                var isSelected = $(this).hasClass("incorrect");
                var isUserSelected = $(this).hasClass("selected");

                if (isCorrect) {
                    $(this).removeClass("correct");
                    // $(this).css("color", ""); // Remove color from the correct answer
                } else if (isSelected) {
                    $(this).css("color", "red");
                } else if (isUserSelected) {
                    var checkbox = $(this).closest(".question").find("input[type='checkbox']");
                    if (checkbox.is(":checked")) {
                        $(this).css("color", "yellow"); // Mark user's answer with yellow color
                    }
                }
            });
        });
    </script>


    @yield('scripts')
</body>

</html>
{{--  @can('user_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.userManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('permission_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.permissions.index') }}">
                                            {{ trans('cruds.permission.title') }}
                                        </a>
                                    @endcan
                                    @can('role_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.roles.index') }}">
                                            {{ trans('cruds.role.title') }}
                                        </a>
                                    @endcan
                                    @can('user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.users.index') }}">
                                            {{ trans('cruds.user.title') }}
                                        </a>
                                    @endcan
                                    @can('cour_access')
                                        <a class="dropdown-item" href="{{ route('frontend.cours.index') }}">
                                            {{ trans('cruds.cour.title') }}
                                        </a>
                                    @endcan
                                    @can('quiz_access')
                                        <a class="dropdown-item" href="{{ route('frontend.quizzes.index') }}">
                                            {{ trans('cruds.quiz.title') }}
                                        </a>
                                    @endcan
                                    @can('quiz_question_access')
                                        <a class="dropdown-item" href="{{ route('frontend.quiz-questions.index') }}">
                                            {{ trans('cruds.quizQuestion.title') }}
                                        </a>
                                    @endcan
                                    @can('question_reponse_access')
                                        <a class="dropdown-item" href="{{ route('frontend.question-reponses.index') }}">
                                            {{ trans('cruds.questionReponse.title') }}
                                        </a>
                                    @endcan
                                    @can('utilisateur_reponse_access')
                                        <a class="dropdown-item" href="{{ route('frontend.utilisateur-reponses.index') }}">
                                            {{ trans('cruds.utilisateurReponse.title') }}
                                        </a>
                                    @endcan
                                    @can('score_quiz_access')
                                        <a class="dropdown-item" href="{{ route('frontend.score-quizzes.index') }}">
                                            {{ trans('cruds.scoreQuiz.title') }}
                                        </a>
                                    @endcan
                                    @can('progression_access')
                                        <a class="dropdown-item" href="{{ route('frontend.progressions.index') }}">
                                            {{ trans('cruds.progression.title') }}
                                        </a>
                                    @endcan
                                    @can('commentaire_access')
                                        <a class="dropdown-item" href="{{ route('frontend.commentaires.index') }}">
                                            {{ trans('cruds.commentaire.title') }}
                                        </a>
                                    @endcan
                                    @can('contenu_access')
                                        <a class="dropdown-item" href="{{ route('frontend.contenus.index') }}">
                                            {{ trans('cruds.contenu.title') }}
                                        </a>
                                    @endcan
                                   @can('video_access')
                                        <a class="dropdown-item" href="{{ route('frontend.videos.index') }}">
                                            {{ trans('cruds.video.title') }}
                                        </a>
                                    @endcan 
@can('user_alert_access')
    <a class="dropdown-item" href="{{ route('frontend.user-alerts.index') }}">
        {{ trans('cruds.userAlert.title') }}
    </a>
@endcan --}}
