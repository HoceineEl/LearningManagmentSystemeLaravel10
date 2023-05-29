@can('quiz_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.quizzes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.quiz.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.quiz.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-lessonQuizzes">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.quiz.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.quiz.fields.nom') }}
                        </th>
                        <th>
                            {{ trans('cruds.quiz.fields.lesson') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $key => $quiz)
                        <tr data-entry-id="{{ $quiz->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $quiz->id ?? '' }}
                            </td>
                            <td>
                                {{ $quiz->nom ?? '' }}
                            </td>
                            <td>
                                {{ $quiz->lesson->label ?? '' }}
                            </td>
                            <td>
                                @can('quiz_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.quizzes.show', $quiz->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('quiz_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.quizzes.edit', $quiz->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('quiz_delete')
                                    <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('quiz_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.quizzes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-lessonQuizzes:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection