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
<!-- SUBHEADER::TOOLBAR -->
@section('subheader-toolbar')
<div class="btn-group">
  @can(Request::segment(1).'.restore.*')
  <button class="btn btn-round"><a href="#" class="text-dark form-restore" data-id="{{Request::segment(2)}}"><i class="fa fa-trash-restore"></i> Restore</a></button>
  @endcan
  @can(Request::segment(1).'.delete.*')
  <button class="btn btn-round" class="text-danger"><a href="#" class="text-danger form-delete" data-id="{{Request::segment(2)}}"><i class="fa fa-trash"></i> Delete Forever</a></button>
  @endcan
</div>
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
            <form method="GET" action="{{url($segments[0])}}" enctype="multipart/form-data" >
              @method('GET')
              @csrf
              @foreach($forms as $fields)
              <div class="form-group row">
                @foreach($fields as $item)
                <div class="{{$item['class']}}">
                  @php ($field = $structures[$item['field']])
                  @component('forms.forms', ['field' => $field, 'readonly' => true])@endcomponent
                </div>
                @endforeach
              </div>
              @endforeach
              <div class="btn-group">
                <a class="btn btn-round btn-light" href="{{url($segments[0])}}/trash" role="button"><i class="fa fa-close"></i> Cancel</a>
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
<form method="POST" id="form-restore" action="" enctype="multipart/form-data" >
  @method('PUT')
  @csrf
</form>
@endsection

@section('js')
<script>
$(document).ready(function() {

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
      text: "Are you sure want to delete permanent this data?",
      icon: "warning",
      buttons: true,
      showCancelButton: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete.isConfirmed) {
        $('#form-delete').attr('action', '{{url($segments[0])}}/'+id+'/delete');
        $('#form-delete').submit();
      }
    });
  });
});
</script>
@endsection
