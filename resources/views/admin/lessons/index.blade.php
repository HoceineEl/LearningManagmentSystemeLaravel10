@extends('layouts.admin')
@section('content')
{{-- @can('lesson_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="#">
                {{ trans('global.add') }} {{ trans('cruds.lesson.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
<div class="card">
      
        <div class="card-body" id="main">
            <ul class="section-list">
              <li class="section">
                <i class="fa fa-bars handle-section"></i>
                <span id="section-title">Item 6</span>
                <ul class="lesson-list">
                  <button id="" class="btn btn-outline-dark btn-el">+ Add Lesson</button>
                    <li class="lesson">
                      <i class="fa fa-bars handle"></i>
                      <div id="lesson-box" style="display: inline;">
                        <input value="New Lesson" class="form-control input m-2 border border-dark" type="text" name="" id="input">
                        <button class="btn btn-primary button save-button">Save</button>
                        <button class="btn btn-light button cancel-button">Cancel</button>
                      </div>
                    </li>
                  <li class="lesson">
                    <i class="fa fa-bars handle"></i>
                    <div id="lesson-box" style="display: inline;">
                      <input value="New Lesson" class="form-control input m-2 border border-dark" type="text" id="input">
                      <button class="btn btn-primary button save-button">Save</button>
                      <button class="btn btn-light button cancel-button">Cancel</button>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
        
            @foreach($sections as $section)
            <ul class="section-list" data-section-id="{{ $section->id }}">
              <li class="section" data-section-id="{{ $section->id }}">
                <i class="fa fa-bars handle-section"></i>
                <span id="section-title">{{ $section->label }}</span>
                <a href="" class="section-h-btn">Quick Actions</a>
                <ul class="lesson-list" data-section-id="{{ $section->id }}">
                  <button  class="btn btn-outline-dark btn-el">+ Add Lesson</button>
                  @if(isset($lessons[$section->id]))
                  @foreach($lessons[$section->id] as $lesson)
                  <li class="lesson" data-lesson-id="{{ $lesson->id }}">
                    <i class="fa fa-bars handle"></i>
                    <a href="#" id="lesson-link">{{ $lesson->label }}</a>
                    <a href="#" class="publish-btn">Publish</a>
                  </li>
                  @endforeach
                  @endif
                </ul>
              </li>
            </ul>
            @endforeach

            <button class="btn btn-dark" id="btn">Add New Section</button>
          </div>
         
    </div>




@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('lesson_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "",
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
  let table = $('.datatable-lesson:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})
</script>

@endsection