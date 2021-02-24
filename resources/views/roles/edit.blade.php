@extends('layouts.metronic.app')
<!-- SUBHEADER::TITLE -->
@section('subheader-title')Edit {{$title}}@endsection

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
            @if($description)
            <p class="card-text">{{$description}}</p>
            @endif

            <form method="POST" action="{{url(Request::segment(1).'/'.Request::segment(2))}}" enctype="multipart/form-data">
              @method('PUT')
              @csrf
              <div class="row">
                <div class="col-6">
                  @foreach($forms as $fields)
                  <div class="form-group row">
                    @foreach($fields as $item)
                    <div class="{{$item['class']}}">
                      @php ($field = $structures[$item['field']])
                      @component('forms.forms', ['field' => $field])@endcomponent
                    </div>
                    @endforeach
                  </div>
                  @endforeach
                  <div class="btn-group">
                    <a class="btn btn-round btn-light" href="{{url(Request::segment(1).'/'.Request::segment(2))}}" role="button"><i class="fa fa-close"></i> Cancel</a>
                    <button type="button" class="btn btn-round btn-danger">
                      <a href="#" class="text-light form-delete" data-id="{{Request::segment(2)}}">
                        <i class="fa fa-trash"></i> Delete
                      </a>
                    </button>
                    <button type="submit" class="btn btn-round btn-success"><i class="fa fa-check"></i> Save</button>
                  </div>
                </div>
                <div class="col-6">
                  <table class="table table-striped datatable" style="width:100%">
                    <thead>
                      <tr>
                        <th>permissions</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="table-borderless"></tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ Default ordering table -->
<form method="POST" id="form-delete" action="" enctype="multipart/form-data">
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
      if (!id) return;

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
            $('#form-delete').attr('action', '{{url($segments[0])}}/' + id);
            $('#form-delete').submit();
          }
        });
    });

    @if(session('success'))
    Swal.fire("Success!", "{{session('success')}}", "success");
    @endif

    @if(session('info'))
    Swal.fire("Info!", "{{session('info')}}", "info");
    @endif

    @if(session('warning'))
    Swal.fire("Warning!", "{{session('warning')}}", "warning");
    @endif

    @if(session('error'))
    Swal.fire("Error!", "{{session('error')}}", "error");
    @endif

  });

  $(async () => {
    let urlPermissions = "{{ url('/api/v1/permissions') }}"
    let roles = await JSON.parse("{{ json_encode($roles) }}")

    var datatable = $('.datatable').DataTable({
      order: [],
      columnDefs: [{
        "targets": -1,
        "data": null,
        "defaultContent": '',
        "bSortable": false,
        "orderable": false,
      }],
      "scrollX": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": urlPermissions,
        headers: {
          'Authorization': 'Bearer {{session('bearer_token')}}'
        },
        "data": {
          "format": "datatable",
        }
      },
      createdRow: function(row, data, index) {
        if (roles.includes(data.id)) {
          $(row).find('td:last-child').addClass('float-right');
          $(row).find('td:last-child').append(`
            <input type="hidden" value="${data.name}">
            <a href="#" class="minus" style="display: inline-block"><i class="fa fa-minus"> </i></a>
            <a href="#" class="add" style="display: none"><i class="fa fa-plus"> </i></a>
          `);
        } else {
          $(row).find('td:last-child').addClass('float-right');
          $(row).find('td:last-child').append(`
            <input type="hidden" value="${data.name}">
            <a href="#" class="minus" style="display: none"><i class="fa fa-minus"> </i></a>
            <a href="#" class="add" style="display: inline-block"><i class="fa fa-plus"> </i></a>
          `);
        }
      },
      "columns": [{
        data: 'name'
      }, {
        data: null
      }]
    })
  })

  $(() => {
    let id = "{{ $data['id'] }}"
    let urlGivePermission = "{{ url('/api/v1/role_has_permission/') }}" + "/" + id + "/give_permission"

    $('table.dataTable').on('click', 'a.add', (element) => {
      let value = element.currentTarget.previousElementSibling.previousElementSibling.value
      $.ajax({
        url: urlGivePermission,
        type: "POST",
        headers: {
          'Authorization': 'Bearer {{session('bearer_token')}}'
        },
        data: {
          "_token": "{{ csrf_token() }}",
          permission: value
        }
      }).done(res => {
        toastr.success('Data deleted successfully.', 'Success!');
        element.currentTarget.style.display = "none"
        element.currentTarget.previousElementSibling.style.display = "inline-block"
      }).catch(err => {
        toastr.error('Error happened!', 'Error!');
      });
    })
  })

  $(() => {
    let id = "{{ $data['id'] }}"
    let urlGivePermission = "{{ url('/api/v1/role_has_permission/') }}" + "/" + id + "/revoke_permission"

    $('table.dataTable').on('click', 'a.minus', (element) => {
      element.currentTarget.style.display = "none"
      element.currentTarget.nextElementSibling.style.display = "inline-block"
      let value = element.currentTarget.previousElementSibling.value
      $.ajax({
        url: urlGivePermission,
        type: "POST",
        headers: {
          'Authorization': 'Bearer {{session('bearer_token')}}'
        },
        data: {
          "_token": "{{ csrf_token() }}",
          permission: value
        }
      }).done(res => {
        toastr.success('Data deleted successfully.', 'Success!');
        element.currentTarget.style.display = "none"
        element.currentTarget.nextElementSibling.style.display = "inline-block"
      }).catch(err => {
        toastr.error('Error happened!', 'Error!');
      });
    })
  })
</script>
@endsection