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
@can($collection.'.create.*')
<a href="{{url(Request::segment(1))}}/create" class="btn btn-clean btn-sm font-size-base mr-1"><i class="fa fa-plus"></i> New</a>
@endcan
@can($collection.'.import.*')
<a href="{{url(Request::segment(1))}}/import" class="btn btn-clean btn-sm font-size-base mr-1"><i class="fa fa-download"></i> Import</a>
@endcan
@can($collection.'.export.*')
<a href="{{url(Request::segment(1))}}/export" class="btn btn-clean btn-sm font-size-base mr-1"><i class="fa fa-upload"></i> Export</a>
@endcan
@can($collection.'.trash.*')
<a href="{{url(Request::segment(1))}}/trash" class="btn btn-clean btn-sm font-size-base mr-1 text-danger"><i class="fa fa-trash"></i> Trash</a>
@endcan
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
            <table class="table table-striped datatable" style="width:100%">
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
@endsection

@section('js')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function() {

  $(document).on('click', '.form-delete', function() {

    var id = $(this).data('id');
    if(!id) return;

    Swal.fire({
      title: "Are you sure?",
      text: "Are you sure want to delete this data?",
      icon: "warning",
      showCancelButton: true,
    })
    .then((willDelete) => {
      if (willDelete.isConfirmed) {
        $.ajax({
          url: "{{url('/api/v1/'.$collection)}}"+id,
          type: "POST",
          headers: {
            'Authorization': 'Bearer {{session('bearer_token')}}'
          },
          data: {
            "_token": "{{ csrf_token() }}",
            "_method": "delete"
          }
        }).done((response) => {
          toastr.success('Data deleted successfully.', 'Success!');
          datatable.ajax.reload();
        }).catch(err => {
          toastr.error('Error happened!', 'Error!');
        });
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
  var datatable = $('.datatable').DataTable( {
    order: [],
    "scrollX": true,
    columnDefs: columnDefs,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "{{url('/api/v1/'.$collection)}}",
      headers: {
        'Authorization': 'Bearer {{session('bearer_token')}}'
      },
      "data":  function ( data ) {
        data['format'] = "datatable";
        @if(count($references))
        data['relationship'] = <?=json_encode($references)?>;
        @endif

        @if(isset($params))
        const params = <?=json_encode($params)?>;
        for (const key in params) {
          data[key] = params[key]
        }
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
        @can($collection.'.read.*')
        <a href="{{url(Request::segment(1))}}/${data['id']}" class="btn btn-sm btn-clean btn-icon mr-2" title="Show details">
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
        @can($collection.'.update.*')
        <a href="{{url(Request::segment(1))}}/${data['id']}/edit" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
            <span class="svg-icon svg-icon-md">
              <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
                  <title>Stockholm-icons / General / Edit</title>
                  <desc>Created with Sketch.</desc>
                  <defs></defs>
                  <g id="Stockholm-icons-/-General-/-Edit" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                      <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                  </g>
              </svg>
            </span>
        </a>
        @endcan
        @can($collection.'.destroy.*')
        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon form-delete" data-id="/${data['id']}" title="Delete">
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
