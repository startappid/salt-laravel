@extends('layouts.robust')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/sweetalert.css')}}">
@endsection
@section('content')
<div class="content-header row">
  <div class="breadcrumb-wrapper col-8">
    <ol class="breadcrumb">
      @foreach($breadcrumbs as $breadcrumb)
      @if($breadcrumb['active'])
      <li class="breadcrumb-item active">{{$breadcrumb['title']}}</li>
      @else
      <li class="breadcrumb-item"><a href="{{url($breadcrumb['link'])}}">{{$breadcrumb['title']}}</a></li>
      @endif
      @endforeach
    </ol>
  </div>
  <div class="content-header-right text-md-right col-4">
    <div class="btn-group">
      <button class="btn btn-round"><a href="#" class="text-dark form-trash-restore"><i class="fa fa-trash-restore"></i> Restore All</a></button>
      <button class="btn btn-round"><a href="#" class="text-danger form-trash-empty"><i class="fa fa-trash"></i> Empty Trash</a></button>
    </div>
  </div>
</div>

<!-- Default ordering table -->
<section>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$title}}</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
              <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            @if($description)
            <p class="card-text">{{$description}}</p>
            @endif
            <table class="table table-striped default-ordering" style="width:100%">
              <thead>
                <tr>
                  @foreach($structures as $field)
                  @if($field['display'])
                  <th>{{title_case($field['field'])}}</th>
                  @endif
                  @endforeach
                  <th class="sorting_disabled"> </th>
                </tr>
              </thead>
              <tbody class="table-borderless"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ Default ordering table -->
<form method="POST" id="form-delete" action="" enctype="multipart/form-data" >
  @method('DELETE')
  @csrf
</form>
<form method="POST" id="form-restore" action="" enctype="multipart/form-data" >
  @method('PUT')
  @csrf
</form>
<form method="POST" id="form-trash-empty" action="" enctype="multipart/form-data" >
  @method('DELETE')
  @csrf
</form>
<form method="POST" id="form-trash-restore" action="" enctype="multipart/form-data" >
  @method('PUT')
  @csrf
</form>
@endsection

@section('js')
<script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/extensions/sweetalert.min.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function() {

  $(document).on('click', '.form-trash-restore', function() {

    swal({
      title: "Are you sure?",
      text: "Are you sure want to restore all data?",
      icon: "info",
      buttons: true,
      dangerMode: false,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#form-trash-restore').attr('action', '{{url($segments[0])}}/trash/restore');
        $('#form-trash-restore').submit();
      }
    });
  });

  $(document).on('click', '.form-trash-empty', function() {

    swal({
      title: "Are you sure?",
      text: "Are you sure want to delete permanent all data?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#form-trash-empty').attr('action', '{{url($segments[0])}}/trash/empty');
        $('#form-trash-empty').submit();
      }
    });
  });

  $(document).on('click', '.form-restore', function() {

    var id = $(this).data('id');
    if(!id) return;
    swal({
      title: "Are you sure?",
      text: "Are you sure want to restore this data?",
      icon: "info",
      buttons: true,
      dangerMode: false,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#form-restore').attr('action', '{{url($segments[0])}}/'+id+'/restore');
        $('#form-restore').submit();
      }
    });
  });

  $(document).on('click', '.form-delete', function() {

    var id = $(this).data('id');
    if(!id) return;

    swal({
      title: "Are you sure?",
      text: "Are you sure want to delete this data?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#form-delete').attr('action', '{{url($segments[0])}}'+id+'/delete');
        $('#form-delete').submit();
      }
    });
  });

  @if (session('success'))
    toastr.success('{{session('success')}}', 'Success!');
  @endif

  @if (session('info'))
    toastr.info('{{session('info')}}', 'Info!');
  @endif

  @if (session('warning'))
    toastr.warning('{{session('warning')}}', 'Warning!');
  @endif

  @if (session('error'))
    toastr.error('{{session('error')}}', 'Error!');
  @endif

  // DATATABLE
  var columns = <?=json_encode($columns)?>;
  columns.push({
    data: '',
    defaultContent: ''
  });
  var datatable = $('.default-ordering').DataTable( {
    order: [],
    "scrollX": true,
    columnDefs: [{ orderable: false, targets: -1 }],
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "{{url('/api/v1/'.Request::segment(1))}}/trash",
      "data": {
        "_token": "{{ csrf_token() }}",
        "format": "datatable"
      }
    },
    createdRow: function ( row, data, index ) {
      $(row).find('td:last-child').addClass('float-right');
      $(row).find('td:last-child').append(`
        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
          <button type="button" class="btn btn-round"><a href="{{url(Request::segment(1))}}/${data['id']}/trashed" class="text-dark"><i class="fa fa-eye"></i> Detail</a></button>
          <div class="btn-group" role="group">
            <button id="btn-group-drop-${data['id']}" type="button" class="btn btn-round dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="dropdown-menu" aria-labelledby="btn-group-drop-${data['id']}">
              <a href="{{url(Request::segment(1))}}/${data['id']}/trashed" class="dropdown-item"><i class="fa fa-eye"></i> Detail</a>
              <a href="#" class="dropdown-item form-restore" data-id="${data['id']}"><i class="fa fa-trash-restore"></i> Restore</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item text-danger form-delete" data-id="/${data['id']}"><i class="fa fa-trash"></i> Delete Permanent</a>
            </div>
          </div>
        </div>
      `);
    },
    "columns": columns
  });

});
</script>
@endsection