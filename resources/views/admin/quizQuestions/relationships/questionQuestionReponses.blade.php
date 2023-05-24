@can('question_reponse_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.question-reponses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.questionReponse.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.questionReponse.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-questionQuestionReponses">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.questionReponse.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.questionReponse.fields.question') }}
                        </th>
                        <th>
                            {{ trans('cruds.questionReponse.fields.reponse') }}
                        </th>
                        <th>
                            {{ trans('cruds.questionReponse.fields.est_correct') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questionReponses as $key => $questionReponse)
                        <tr data-entry-id="{{ $questionReponse->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $questionReponse->id ?? '' }}
                            </td>
                            <td>
                                {{ $questionReponse->question->question ?? '' }}
                            </td>
                            <td>
                                {{ $questionReponse->reponse ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $questionReponse->est_correct ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $questionReponse->est_correct ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('question_reponse_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.question-reponses.show', $questionReponse->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('question_reponse_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.question-reponses.edit', $questionReponse->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('question_reponse_delete')
                                    <form action="{{ route('admin.question-reponses.destroy', $questionReponse->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('question_reponse_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.question-reponses.massDestroy') }}",
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
  let table = $('.datatable-questionQuestionReponses:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection