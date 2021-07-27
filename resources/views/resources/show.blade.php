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
                <a class="btn btn-round btn-light" href="{{url($segments[0])}}" role="button"><i class="fa fa-close"></i> Cancel</a>
                @can(Request::segment(1).'.destroy.*')
                <button type="button" class="btn btn-round btn-danger">
                  <a href="#" class="text-light form-delete" data-id="{{Request::segment(2)}}">
                    <i class="fa fa-trash"></i> Delete
                  </a>
                </button>
                @endcan
                @can(Request::segment(1).'.update.*')
                <button type="button" class="btn btn-round btn-success">
                  <a href="{{url(Request::segment(1).'/'.Request::segment(2).'/edit')}}" class="text-light">
                    <i class="fa fa-edit"></i> Edit
                  </a>
                </button>
                @endcan
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
        $('#form-delete').attr('action', '{{url($segments[0])}}/'+id);
        $('#form-delete').submit();
      }
    });
  });
});
</script>
@endsection
