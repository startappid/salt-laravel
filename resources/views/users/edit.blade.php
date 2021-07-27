@extends('layouts.metronic.app')
<!-- SUBHEADER::TITLE -->
@section('subheader-title')Edit {{$title}}@endsection

@section('subheader-toolbar')
@hasrole('superadmin')
<a href="{{ url(Request::segment(1).'/'.Request::segment(2).'/role') }}" class="btn btn-clean btn-sm font-size-base mr-1"><i class="fa fa-user"></i>Ganti Role</a>
@endhasrole
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
            @if($description)
            <p class="card-text">{{$description}}</p>
            @endif

            <form method="POST" action="{{url(Request::segment(1).'/'.Request::segment(2).'/edit')}}" enctype="multipart/form-data">
              @method('PUT')
              @csrf
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
</script>
@endsection