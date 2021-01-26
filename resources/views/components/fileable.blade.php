@php ($readonly = isset($readonly)? true: false)
<div class="form-group row">
  @if(count($items))
  <div class="col-12">
    <div id="carousel-files" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        @foreach($items as $key => $item)
        <li data-target="#carousel-files" data-slide-to="0" class="{{$key == 0? 'active': ''}}"></li>
        @endforeach
      </ol>
      <div class="carousel-inner">
        @foreach($items as $key => $item)
        <div class="carousel-item {{$key == 0? 'active': ''}}">
          <img src="{{$item['fullpath']}}" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Some representative placeholder content for the first slide.</p>
          </div>
        </div>
        @endforeach
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
  @endif
  @if(!$readonly)
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
  @endif
</div>

@section('js')
@parent
<script>
$(function() {
  $('input#form-files-input').on('change', function() {
    var formData = new FormData();
    var file = $(this)[0].files[0];
    formData.append('file', file);
    formData.append('foreign_table', '{{$table}}');
    formData.append('foreign_id', '{{$id}}');

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
      setTimeout(() => {
        location.reload();
      }, 1600);
    }).catch(err => {
      var response = err.responseJSON;
      toastr.error(response.message, 'Error!');
    });
  });
});
</script>
@stop
