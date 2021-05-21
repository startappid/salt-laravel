@extends('layouts.metronic.app')
<!-- SUBHEADER::TITLE -->
@section('subheader-title'){{$title}}@endsection

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
            <form method="GET" action="{{url($segments[0])}}" enctype="multipart/form-data">
              <div class="form-group row">
                <div class="col-6">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="form-username">
                        Username
                      </label>
                      <input readonly type="text" class="form-control" value="{{ $data['username'] }}" aria-describedby="form-help-username">
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <table class="table table-striped datatable" style="width:100%">
                    <thead>
                      <tr>
                        <th>Roles</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="table-borderless"></tbody>
                  </table>
                </div>
              </div>

              <div class="btn-group">
                <a class="btn btn-round btn-light" href="{{url($segments[0].'/'.$segments[1].'/edit')}}" role="button"></i>Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
  $(() => {
    let urlRole = "{{ url('/api/v1/roles') }}"
    let roles = <?= json_encode($role) ?>

    var datatables = $('.datatable').DataTable({
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
        "url": urlRole,
        headers: {
          'Authorization': "Bearer {{session('bearer_token')}}"
        },
        "data":  function ( data ) {
          data['format'] = "datatable";
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
      createdRow: function(row, data, index) {
        if (roles.includes(data.name)) {
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
    let urlRole = "{{ url('/api/v1/user_has_role/') }}" + "/" + id + "/assign_role"

    $('table.dataTable').on('click', 'a.add', (element) => {
      let value = element.currentTarget.previousElementSibling.previousElementSibling.value
      $.ajax({
        url: urlRole,
        type: "POST",
        headers: {
          'Authorization': "Bearer {{session('bearer_token')}}"
        },
        data: {
          "_token": "{{ csrf_token() }}",
          role: value
        }
      }).done(res => {
        toastr.success('Add role successfully.', 'Success!');
        element.currentTarget.style.display = "none"
        element.currentTarget.previousElementSibling.style.display = "inline-block"
      }).catch(err => {
        toastr.error('Error happened!', 'Error!');
      });
    })
  })

  $(() => {
    let id = "{{ $data['id'] }}"
    let urlRole = "{{ url('/api/v1/user_has_role/') }}" + "/" + id + "/remove_role"

    $('table.dataTable').on('click', 'a.minus', (element) => {
      element.currentTarget.style.display = "none"
      element.currentTarget.nextElementSibling.style.display = "inline-block"
      let value = element.currentTarget.previousElementSibling.value
      $.ajax({
        url: urlRole,
        type: "POST",
        headers: {
          'Authorization': "Bearer {{session('bearer_token')}}"
        },
        data: {
          "_token": "{{ csrf_token() }}",
          role: value
        }
      }).done(res => {
        toastr.success('Delete role successfully.', 'Success!');
        element.currentTarget.style.display = "none"
        element.currentTarget.nextElementSibling.style.display = "inline-block"
      }).catch(err => {
        toastr.error('Error happened!', 'Error!');
      });
    })
  })
</script>
@endsection
