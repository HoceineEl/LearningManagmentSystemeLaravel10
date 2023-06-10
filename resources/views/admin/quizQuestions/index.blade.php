@extends('layouts.admin')
@section('content')
    @can('quiz_question_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ url('admin/quiz-questions/create/' . $quiz1->id) }}">
                    {{ trans('global.add') }} {{ trans('cruds.quizQuestion.title_singular') }}
                </a>

            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.quizQuestion.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-QuizQuestion">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.quizQuestion.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.quizQuestion.fields.quiz') }}
                            </th>
                            <th>
                                {{ trans('cruds.quizQuestion.fields.question') }}
                            </th>
                            <th>
                                {{ trans('cruds.quizQuestion.fields.ordre') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizQuestions as $key => $quizQuestion)
                            <tr data-entry-id="{{ $quizQuestion->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $quizQuestion->id ?? '' }}
                                </td>
                                <td>
                                    {{ $quizQuestion->quiz->nom ?? '' }}
                                </td>
                                <td>
                                    {{ $quizQuestion->question ?? '' }}
                                </td>
                                <td>
                                    {{ $quizQuestion->ordre ?? '' }}
                                </td>
                                <td>
                                    @can('quiz_question_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.quiz-questions.show', $quizQuestion->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('quiz_question_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.quiz-questions.edit', $quizQuestion->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('quiz_question_delete')
                                        <form action="{{ route('admin.quiz-questions.destroy', $quizQuestion->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('quiz_question_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.quiz-questions.massDestroy') }}",
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
            let table = $('.datatable-QuizQuestion:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
