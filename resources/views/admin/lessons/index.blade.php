@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body" id="main">
            @foreach ($sections as $section)
                <ul class="section-list" data-section-id="{{ $section->id }}">
                    <li class="section card bg-light text-dark" data-section-name="{{ $section->label }}" data-section-id="{{ $section->id }}">
                        <div class="d-flex justify-content-between header">
                            <div>
                                <i class="fa fa-bars handle-section"></i>
                                <span class="card-title section-title">{{ $section->label }}</span>
                            </div>
                            <div class="dropDown">
                                <span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="fa fa-ellipsis-v info-section"></i></span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="padding: 0%">
                                    <li><button type="button"
                                            class="btn btn-primary dropdown-item edit-section">Edit</button></li>
                                    <li><button type="button" class="btn btn-danger dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#deleteSection{{ $section->id }}">
                                            Delete
                                        </button></li>
                                    {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                                </ul>

                            </div>
                            {{-- delete a section's modal --}}
                            <div class="modal fade" id="deleteSection{{ $section->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete a Section</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Do You Want To Delete The Section  ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger delete-section">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="lesson-list" data-section-id="{{ $section->id }}">
                            <button class="btn btn-outline-dark btn-el">+ Add Lesson</button>
                            @if (isset($lessons[$section->id]))
                                @foreach ($lessons[$section->id] as $lesson)
                                    <li class="lesson d-flex justify-content-between card flex-row" style="background-color: rgba(231, 235, 240, 0.795);" data-lesson-id="{{ $lesson->id }}"
                                        data-lesson-name="{{ $lesson->label }}">
                                        <div>
                                            <i class="fa fa-bars handle"></i>
                                            <a class="card-title" href="#" id="lesson-link" data-bs-toggle="modal"
                                                data-bs-target="#addContentModal{{ $lesson->id }}">
                                                {{ $lesson->label }}
                                            </a>
                                        </div>
                                        <div class="dropDownL">
                                            <span id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="fa fa-ellipsis-v info"></i></span>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                style="padding: 0%">
                                                <li><button type="button"
                                                        class="btn btn-primary dropdown-item edit-lesson">Edit</button></li>
                                                <li><button type="button" class="btn btn-danger dropdown-item"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteLesson{{ $lesson->id }}">
                                                        Delete
                                                    </button></li>

                                            </ul>
                                        </div>
                                        {{-- delete a lesson's modal --}}
                                        <div class="modal fade" id="deleteLesson{{ $lesson->id }}"
                                            data-lesson-id="{{ $lesson->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete a Lesson
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Do You Want To Delete The Lesson ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="button"
                                                            class="btn btn-danger delete-lesson">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- add cotent's modal --}}
                                        <div class="modal fade" id="addContentModal{{ $lesson->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="addContentModalLabel{{ $lesson->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="addContentModalLabel{{ $lesson->id }}">AddContent for
                                                        </h5>
                                                        <span class=" modal-title h5 ps-2"
                                                            style="color:rgb(48, 99, 129)">{{ $lesson->label }}</span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="content-list d-flex ">
                                                            <li class="m-4">
                                                                <a class="btn btn-success"
                                                                    href="{{ route('videos.create', ['lesson' => $lesson->id]) }}">
                                                                    <i class="fa fa-video-camera"></i> Add Video
                                                                </a>
                                                            </li>
                                                            <li class="m-4">
                                                                <a class="btn btn-primary"
                                                                    href="{{ url('admin/quizzes/create/' . $lesson->id) }}">
                                                                    <i class="fa fa-question-circle"></i> Add Quiz
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                </ul>
            @endforeach
        </div>
    <div> 
    <div>
        <button class="btn btn-dark" id="btn" data-cour-id="{{ $cour }}">+ Add New Section</button>
    </div>
    </div>
@endsection

    @section('scripts')
        @parent
        <script>
            $(function() {
                let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('lesson_delete')
                    let deleteButtonTrans =
                        '{{ trans('
                                                                                    <<<<<<< HEAD
                                                                                                            global.datatables.delete ') }}' ===
                        ===
                        =
                        global.datatables.delete ') }}' >>>
                        >>>
                        >
                        f64509e60066a3b1624f40081e9110c7e50f86a8
                    let deleteButton = {
                        text: deleteButtonTrans,
                        url: "",
                        className: 'btn-danger',
                        action: function(e, dt, node, config) {
                            var ids = $.map(dt.rows({
                                selected: true
                            }).nodes(), function(entry) {
                                return $(entry).data('entry-id')
                            });
                            if (ids.length === 0) {
                                alert(
                                    '{{ trans('
                                                                                                                                    <<<<<<< HEAD
                                                                                                                                                                                            global.datatables.zero_selected ') }}'
                                )
                                return
                            }
                            if (confirm(
                                    '{{ trans('
                                                                                                                                                                                    global.areYouSure ') }}'
                                )) {
                                ===
                                ===
                                =
                                global.datatables.zero_selected ') }}'
                            )
                            return
                        }
                        if (confirm(
                                '{{ trans('
                                                                                                                                                                                                    global.areYouSure ') }}'
                            )) {
                            >>>
                            >>>
                            >
                            f64509e60066a3b1624f40081e9110c7e50f86a8
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan
            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
            });
            let table = $('.datatable-lesson:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            })
        </script>
    @endsection
