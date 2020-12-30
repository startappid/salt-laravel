@extends('layouts.metronic.app')
@section('css')
<!--begin::Page Vendors Styles(used by this page)-->
<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
@endsection
<!-- SUBHEADER::TITLE -->
@section('subheader-title'){{$title}}@endsection

<!-- SUBHEADER::TOOLBAR -->
@section('subheader-toolbar')
<a href="{{url(Request::segment(1))}}/create" class="btn btn-clean btn-sm font-size-base mr-1"><i class="fa fa-plus"></i> New</a>
<a href="{{url(Request::segment(1))}}/import" class="btn btn-clean btn-sm font-size-base mr-1"><i class="fa fa-download"></i> Import</a>
<a href="{{url(Request::segment(1))}}/export" class="btn btn-clean btn-sm font-size-base mr-1"><i class="fa fa-upload"></i> Export</a>
<a href="{{url(Request::segment(1))}}/trash" class="btn btn-clean btn-sm font-size-base mr-1 text-danger"><i class="fa fa-trash"></i> Trash</a>
@endsection
<!-- SUBHEADER::ACTIONS -->
@section('subheader-actions')
<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
@foreach($breadcrumbs as $breadcrumb)
    @if($breadcrumb['active'])
    <li class="breadcrumb-item active">{{$breadcrumb['title']}}</li>
    @else
    <li class="breadcrumb-item">
        <a href="{{url($breadcrumb['link'])}}" class="text-muted">{{$breadcrumb['title']}}</a>
    </li>
    @endif
@endforeach
</ul>
@endsection

@section('content')
<!-- Default ordering table -->
<section>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            <table class="table table-striped default-ordering" style="width:100%">
              <thead>
                <tr>
                  @foreach($structures as $field)
                  @if($field['display'])
                  <th>{{Str::title($field['name'])}}</th>
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
@endsection

@section('js')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function() {

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
        $('#form-delete').attr('action', '{{url($segments[0])}}'+id);
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
      "url": "{{url('/api/v1/'.Request::segment(1))}}",
      "data": {
        "_token": "{{csrf_token()}}",
        "format": "datatable"
      }
    },
    createdRow: function ( row, data, index ) {
      $(row).find('td:last-child').addClass('float-right');
      $(row).find('td:last-child').append(`
        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
          <button type="button" class="btn btn-round"><a href="{{url(Request::segment(1))}}/${data['id']}" class="text-dark"><i class="fa fa-eye"></i> Detail</a></button>
          <div class="btn-group" role="group">
            <button id="btn-group-drop-/${data['id']}" type="button" class="btn btn-round dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="dropdown-menu" aria-labelledby="btn-group-drop-/${data['id']}">
              <a href="{{url(Request::segment(1))}}/${data['id']}" class="dropdown-item"><i class="fa fa-eye"></i> Detail</a>
              <a href="{{url(Request::segment(1))}}/${data['id']}/edit" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item text-danger form-delete" data-id="/${data['id']}"><i class="fa fa-trash"></i> Delete</a>
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
