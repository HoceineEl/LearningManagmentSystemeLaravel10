@can('video_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.videos.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.video.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.video.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-contenuVideos">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.video.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.video.fields.video') }}
                        </th>
                        <th>
                            {{ trans('cruds.video.fields.miniature') }}
                        </th>
                        <th>
                            {{ trans('cruds.video.fields.contenu') }}
                        </th>
                        <th>
                            {{ trans('cruds.contenu.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.contenu.fields.id_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($videos as $key => $video)
                        <tr data-entry-id="{{ $video->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $video->id ?? '' }}
                            </td>
                            <td>
                                @if($video->video)
                                    <a href="{{ $video->video->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($video->miniature)
                                    <a href="{{ $video->miniature->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $video->miniature->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $video->contenu->ordre ?? '' }}
                            </td>
                            <td>
                                @if($video->contenu)
                                    {{ $video->contenu::TYPE_SELECT[$video->contenu->type] ?? '' }}
                                @endif
                            </td>
                            <td>
                                {{ $video->contenu->id_type ?? '' }}
                            </td>
                            <td>
                                @can('video_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.videos.show', $video->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('video_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.videos.edit', $video->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('video_delete')
                                    <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('video_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.videos.massDestroy') }}",
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
  let table = $('.datatable-contenuVideos:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection