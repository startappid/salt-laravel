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
  <!--
  <div class="content-header-right text-md-right col-4">
    <div class="btn-group">
      <button class="btn btn-round"><i class="fa fa-plus"></i> New</button>
      <button class="btn btn-round"><i class="fa fa-trash"></i> Trash</button>
    </div>
  </div>
  -->
</div>

<!-- Default ordering table -->
<section>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Edit {{$title}}</h4>
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

            <form method="POST" action="{{url(Request::segment(1).'/'.Request::segment(2))}}" enctype="multipart/form-data" >
              @method('PUT')
              @csrf

              @foreach($structures as $field)
                @if($field['display'])
                  @component('forms.input', ['field' => $field])
                  @endcomponent
                @endif
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
<form method="POST" id="form-delete" action="" enctype="multipart/form-data" >
  @method('DELETE')
  @csrf
</form>
@endsection

@section('js')
<script src="{{asset('app-assets/vendors/js/extensions/sweetalert.min.js')}}" type="text/javascript"></script>
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
        $('#form-delete').attr('action', '{{url($segments[0])}}/'+id);
        $('#form-delete').submit();
      }
    });
  });

  @if (session('success'))
    swal("Success!", "{{session('success')}}", "success");
  @endif

  @if (session('info'))
    swal("Info!", "{{session('info')}}", "info");
  @endif

  @if (session('warning'))
    swal("Warning!", "{{session('warning')}}", "warning");
  @endif

  @if (session('error'))
    swal("Error!", "{{session('error')}}", "error");
  @endif

});
</script>
@endsection