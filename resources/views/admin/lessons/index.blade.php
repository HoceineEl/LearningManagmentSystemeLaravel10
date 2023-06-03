@extends('layouts.admin')
@section('content')
    <div class="card">

        <div class="card-body" id="main">



            @foreach ($sections as $section)
                <ul class="section-list" data-section-id="{{ $section->id }}">
                    <li class="section" data-section-name="{{ $section->label }}" data-section-id="{{ $section->id }}">
                        <div class="d-flex justify-content-between header">
                            <div>
                                <i class="fa fa-bars handle-section"></i>
                                <span class="section-title">{{ $section->label }}</span>
                            </div>
                            <div class="dropDown">
                                <span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="fa fa-ellipsis-v info-section"></i></span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><button class="dropdown-item edit-section">Edit</button></li>
                                    <li><button class="dropdown-item delete-section">Delete</button></li>
                                    {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <ul class="lesson-list" data-section-id="{{ $section->id }}">
                            <button class="btn btn-outline-dark btn-el">+ Add Lesson</button>
                            @if (isset($lessons[$section->id]))
                                @foreach ($lessons[$section->id] as $lesson)
                                    <li class="lesson d-flex justify-content-between" data-lesson-id="{{ $lesson->id }}">
                                        <div>
                                            <i class="fa fa-bars handle"></i>
                                            <a href="#" id="lesson-link" data-toggle="modal"
                                                data-target="#addContentModal{{ $lesson->id }}">
                                                {{ $lesson->label }}
                                            </a>
                                        </div>
                                        <div>
                                            <span id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="fa fa-ellipsis-v info"></i></span>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><button class="dropdown-item edit-lesson">Edit</button></li>
                                                <li><button class="dropdown-item delete-lesson">Delete</button></li>
                                                {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                                            </ul>
                                        </div>
                                    </li>
                                    <div class="modal fade" id="addContentModal{{ $lesson->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="addContentModalLabel{{ $lesson->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addContentModalLabel{{ $lesson->id }}">
                                                        Add
                                                        Content for {{ $lesson->id }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul class="content-list">
                                                        <li>
                                                            <a
                                                                href="{{ route('videos.create', ['lesson' => $lesson->id]) }}">
                                                                <i class="fa fa-video-camera"></i> Add Video
                                                            </a>

                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-question-circle"></i> Add Quiz
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                </ul>
            @endforeach
        </div>
        <div>
            <button class="btn btn-dark" id="btn" data-cour-id="{{$cour}}">+ Add New Section</button>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('lesson_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
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
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
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
