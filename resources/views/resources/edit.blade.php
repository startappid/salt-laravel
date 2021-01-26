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

            <form method="POST" action="{{url(Request::segment(1).'/'.Request::segment(2))}}" enctype="multipart/form-data" >
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

              <div class="form-group row">
                <div class="col-12">
                  <div id="carousel-files" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-files" data-slide-to="0" class="active"></li>
                      <li data-target="#carousel-files" data-slide-to="1"></li>
                      <li data-target="#carousel-files" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="https://dummyimage.com/600x400/000/fff" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          <h5>First slide label</h5>
                          <p>Some representative placeholder content for the first slide.</p>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="https://dummyimage.com/300x400/000/fff" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          <h5>Second slide label</h5>
                          <p>Some representative placeholder content for the second slide.</p>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="https://dummyimage.com/600x400/000/fff" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          <h5>Third slide label</h5>
                          <p>Some representative placeholder content for the third slide.</p>
                        </div>
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-files" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-files" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
                <div class="col-6 mt-4">
                  <div class="form-group">
                    <label>File Browser</label>
                    <div></div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="form-files-input"/>
                      <label class="custom-file-label" for="form-files-input">Choose file</label>
                    </div>
                  </div>
                </div>
              </div>

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
<script>
$(document).ready(function() {

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
        $('#form-delete').attr('action', '{{url($segments[0])}}/'+id);
        $('#form-delete').submit();
      }
    });
  });

  @if (session('success'))
    Swal.fire("Success!", "{{session('success')}}", "success");
  @endif

  @if (session('info'))
    Swal.fire("Info!", "{{session('info')}}", "info");
  @endif

  @if (session('warning'))
    Swal.fire("Warning!", "{{session('warning')}}", "warning");
  @endif

  @if (session('error'))
    Swal.fire("Error!", "{{session('error')}}", "error");
  @endif

});
</script>

<script>
$(function() {
  $('input#form-files-input').on('change', function() {
    var formData = new FormData();
    var file = $(this)[0].files[0];
    formData.append('file', file);
    $.ajax({
      url: "{{url('/api/v1/files')}}",
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      enctype: 'multipart/form-data',
      data: formData,
      processData: false,
      contentType: false,
    }).done((response) => {
      toastr.success('File uploaded.', 'Success!');
    }).catch(err => {
      var response = err.responseJSON;
      toastr.error(response.message, 'Error!');
    });
  });
});
</script>
@endsection
