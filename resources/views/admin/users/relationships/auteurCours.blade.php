@can('cour_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.cours.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.cour.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.cour.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-auteurCours">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.cour.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.cour.fields.nom') }}
                        </th>
                        <th>
                            {{ trans('cruds.cour.fields.cover') }}
                        </th>
                        <th>
                            {{ trans('cruds.cour.fields.auteur') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cours as $key => $cour)
                        <tr data-entry-id="{{ $cour->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $cour->id ?? '' }}
                            </td>
                            <td>
                                {{ $cour->nom ?? '' }}
                            </td>
                            <td>
                                @if($cour->cover)
                                    <a href="{{ $cour->cover->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $cour->cover->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $cour->auteur->name ?? '' }}
                            </td>
                            <td>
                                @can('cour_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.cours.show', $cour->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('cour_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.cours.edit', $cour->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('cour_delete')
                                    <form action="{{ route('admin.cours.destroy', $cour->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('cour_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.cours.massDestroy') }}",
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
  let table = $('.datatable-auteurCours:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection