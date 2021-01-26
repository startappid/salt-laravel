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

@section('js')
@parent
<script>
$(function() {
  $('input#form-files-input').on('change', function() {
    var formData = new FormData();
    var file = $(this)[0].files[0];
    formData.append('file', file);
    formData.append('foreign_table', '{{$segments[0]}}');
    formData.append('foreign_id', '{{$segments[1]}}');

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
