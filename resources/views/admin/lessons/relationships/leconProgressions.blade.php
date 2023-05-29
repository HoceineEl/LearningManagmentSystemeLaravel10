@can('progression_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.progressions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.progression.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.progression.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-lessonProgressions">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.progression.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.progression.fields.utilisateur') }}
                        </th>
                        <th>
                            {{ trans('cruds.progression.fields.lesson') }}
                        </th>
                        <th>
                            {{ trans('cruds.progression.fields.est_complete') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progressions as $key => $progression)
                        <tr data-entry-id="{{ $progression->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $progression->id ?? '' }}
                            </td>
                            <td>
                                {{ $progression->utilisateur->name ?? '' }}
                            </td>
                            <td>
                                {{ $progression->lesson->label ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $progression->est_complete ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $progression->est_complete ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('progression_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.progressions.show', $progression->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('progression_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.progressions.edit', $progression->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('progression_delete')
                                    <form action="{{ route('admin.progressions.destroy', $progression->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('progression_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.progressions.massDestroy') }}",
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
  let table = $('.datatable-lessonProgressions:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection