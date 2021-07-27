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
<div class="btn-group">
  @can(Request::segment(1).'.restore.*')
  <button class="btn btn-round"><a href="#" class="text-dark form-trash-restore"><i class="fa fa-trash-restore"></i> Restore All</a></button>
  @endcan
  @can(Request::segment(1).'.empty.*')
  <button class="btn btn-round"><a href="#" class="text-danger form-trash-empty"><i class="fa fa-trash"></i> Empty Trash</a></button>
  @endcan
</div>
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
                  <th>{{$field['label']}}</th>
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
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function() {

  $(document).on('click', '.form-trash-restore', function() {

    Swal.fire({
      title: "Are you sure?",
      text: "Are you sure want to restore all data?",
      icon: "info",
      buttons: true,
      showCancelButton: true,
      dangerMode: false,
    })
    .then((willDelete) => {
      if (willDelete.isConfirmed) {
        $('#form-trash-restore').attr('action', '{{url($segments[0])}}/trash/restore');
        $('#form-trash-restore').submit();
      }
    });
  });

  $(document).on('click', '.form-trash-empty', function() {

    Swal.fire({
      title: "Are you sure?",
      text: "Are you sure want to delete permanent all data?",
      icon: "warning",
      buttons: true,
      showCancelButton: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete.isConfirmed) {
        $('#form-trash-empty').attr('action', '{{url($segments[0])}}/trash/empty');
        $('#form-trash-empty').submit();
      }
    });
  });

  $(document).on('click', '.form-restore', function() {

    var id = $(this).data('id');
    if(!id) return;
    Swal.fire({
      title: "Are you sure?",
      text: "Are you sure want to restore this data?",
      icon: "info",
      buttons: true,
      showCancelButton: true,
      dangerMode: false,
    })
    .then((willDelete) => {
      if (willDelete.isConfirmed) {
        $('#form-restore').attr('action', '{{url($segments[0])}}/'+id+'/restore');
        $('#form-restore').submit();
      }
    });
  });

  $(document).on('click', '.form-delete', function() {

    var id = $(this).data('id');
    if(!id) return;

    Swal.fire({
      title: "Are you sure?",
      text: "Are you sure want to delete this data?",
      icon: "warning",
      buttons: true,
      showCancelButton: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete.isConfirmed) {
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
  const columnDefs = [{ orderable: false, targets: -1 }]
  for (const key in columns) {
    const item = columns[key]
    if(!item.reference) continue;
    columnDefs.push({
      "render": function ( data, type, row ) {
        return row[item['relationship']][item['option']['label']];
      },
      "targets": parseInt(key)
    });
  }

  columns.push({
    data: '',
    defaultContent: ''
  });
  var datatable = $('.default-ordering').DataTable( {
    order: [],
    "scrollX": true,
    columnDefs: columnDefs,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "{{url('/api/v1/'.Request::segment(1))}}/trash",
      "headers": {
        'Authorization': 'Bearer {{session('bearer_token')}}'
      },
      "data":  function ( data ) {
        data['format'] = "datatable";
        @if(count($references))
        data['relationship'] = <?=json_encode($references)?>;
        @endif
        const page = (data.start / data.length) + 1
        const search = data.search.value

        data.page = page
        data.limit = data.length
        data.search = search

        const order = data.order
        const orders = {}
        for (const key in order) {
          const column = data.columns[order[key]['column']]
          orders[column['data']] = order[key]['dir']
        }

        if(Object.keys(orders).length) {
          data['orderby'] = orders
        }
      }
    },
    createdRow: function ( row, data, index ) {
      $(row).find('td:last-child').addClass('float-right');
      $(row).find('td:last-child').append(`
        @can(Request::segment(1).'.read.*')
        <a href="{{url(Request::segment(1))}}/${data['id']}/trashed" class="btn btn-sm btn-clean btn-icon mr-2" title="Show details">
            <span class="svg-icon svg-icon-md">
              <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
                  <title>Stockholm-icons / General / Visible</title>
                  <desc>Created with Sketch.</desc>
                  <defs></defs>
                  <g id="Stockholm-icons-/-General-/-Visible" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                      <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" id="Shape" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                      <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" id="Path" fill="#000000" opacity="0.3"></path>
                  </g>
              </svg>
            </span>
        </a>
        @endcan
        @can(Request::segment(1).'.restore.*')
        <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 form-restore" data-id="${data['id']}" title="Restore">
            <span class="svg-icon svg-icon-md">
              <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
                <g>
                  <path style="fill:#66BD21;" d="M241.001,315.978v135c0,8.291,6.709,15,15,15h136.86c17.153,0,32.578-9.536,40.254-24.873
                    l19.127-38.258l4.164-86.869H241.001z"/>
                  <path style="fill:#66BD21;" d="M373.005,37.279c-8.399-13.5-22.5-21.301-38.099-21.301h-27.874l-67.855,71.001l81.98,112.324
                    l109.75-69.626L373.005,37.279z"/>
                  <path style="fill:#66BD21;" d="M67.633,151.579l-60.901,97.2c-8.101,13.2-9,30-2.1,44.099l11.7,23.101l97.161,22.72l63.53-105.879
                    L67.633,151.579z"/>
                </g>
                <g>
                <path style="fill:#78DE28;" d="M326.5,380.479l-90-90c-9.3-9.6-25.499-3.001-25.499,10.499v15c-77.854,0-100.859,0-194.669,0
                  c6.631,13.405,61.971,123.67,62.701,125.099c7.5,15.3,23.099,24.901,40.199,24.901h91.769v15c0,13.5,16.199,20.099,25.499,10.499
                  l90-90C332.501,395.777,332.501,386.179,326.5,380.479z"/>
                <path style="fill:#78DE28;" d="M307.033,15.978H177.132c-15.599,0-29.7,7.8-38.099,21.301l-48.9,77.999l-11.7-7.2
                  c-11.4-6.899-25.501,3.6-22.2,16.5l30,120c1.8,8.101,10.199,12.9,17.999,10.8l120-30c12.9-2.999,15.601-20.4,4.2-27.299l-22.5-13.5
                  C215.874,168.009,296.979,32.851,307.033,15.978z"/>
                <path style="fill:#78DE28;" d="M505.2,248.756l-45.707-73.132l14.228-11.785c5.2-3.12,8.013-9.067,7.119-15.073
                  c-0.894-5.991-5.317-10.869-11.206-12.334l-114.595-30c-8.115-2.021-16.187,2.856-18.179,10.913l-30,120
                  c-1.479,5.874,0.747,12.07,5.61,15.688c4.893,3.589,11.455,3.926,16.655,0.806l19.277-11.572
                  c53.103,82.118,77.281,119.507,103.841,160.578c18.005-36.019,6.694-13.394,55.051-110.114
                  C514.253,278.815,513.446,261.969,505.2,248.756z"/>
                </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
              </svg>
            </span>
        </a>
        @endcan
        @can(Request::segment(1).'.delete.*')
        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon form-delete" data-id="/${data['id']}" title="Delete Permanent">
            <span class="svg-icon svg-icon-md">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                    </g>
                </svg>
            </span>
        </a>
        @endcan
      `);
    },
    "columns": columns
  });

});
</script>
@endsection
