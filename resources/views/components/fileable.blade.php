@php ($readonly = isset($readonly)? true: false)
<div class="form-group row">
  @if(count($items))
  <div class="col-12">
    <div id="carousel-files" class="carousel slide fileable" data-ride="carousel">
      <ol class="carousel-indicators">
        @foreach($items as $key => $item)
        <li data-target="#carousel-files" data-slide-to="0" class="{{$key == 0? 'active': ''}}"></li>
        @endforeach
      </ol>
      <div class="carousel-inner">
        @foreach($items as $key => $item)
        <div class="carousel-item {{$key == 0? 'active': ''}}">
          <img id="{{$item['id']}}" src="{{$item['fullpath']}}" class="d-block m-auto fileable-img" alt="...">
          <div class="carousel-caption d-none">
            <h5>First slide label</h5>
            <p>Some representative placeholder content for the first slide.</p>
          </div>
          <div class="position-absolute button-action top-0 right-0">
            <a href="#" onclick="fullscreen()" id="fullscreen" class="btn btn-primary">
              <i class="flaticon2-arrow-1"></i> Full Screen
            </a>
            @if(!$readonly)
            <a href="#" onclick="deleteImage()" class="btn btn-danger">
              <i class="flaticon2-trash"></i> Delete
            </a>
            @endif
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
        <input
          type="file"
          class="custom-file-input"
          id="form-files-input"
          accept="{{isset($accept)? $accept: '*'}}"
        />
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
          'Authorization': 'Bearer {{session('bearer_token')}}'
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

  function fullscreen() {
    var image = document.querySelector('div.active').firstElementChild.src
    var modal;

    $('div#carousel-files').carousel('pause')

    function removeModal() {
      modal.remove();
      $('body').off('keyup.modal-close');
    }
    modal = $('<div>').css({
      background: 'RGBA(0,0,0,.5) url(' + image + ') no-repeat center',
      backgroundSize: '70% 70%',
      width: '100%',
      height: '100%',
      position: 'fixed',
      zIndex: '10000',
      top: '0',
      left: '0',
    }).click(function() {
      $('div#carousel-files').carousel('cycle')
      removeModal();
    }).appendTo('body');
    $('body').on('keyup.modal-close', function(e) {
      if (e.key === 'Escape') {
        $('div#carousel-files').carousel('cycle')
        removeModal();
      }
    });
  }

  function deleteImage() {
    var image = document.querySelector('div.active').firstElementChild.id
    $('div#carousel-files').carousel('pause')

    Swal.fire({
      title: 'Delete file?',
      icon: 'warning',
      confirmButtonText: 'Yes',
      showDenyButton: true,
      denyButtonText: 'No',
      showCancelButton: false
    }).then((result) => {
      if (result.isConfirmed) {
        var url = "{{url('/api/v1/files')}}" + "/" + image
        $.ajax({
          url: url,
          type: "DELETE",
          headers: {
            'Authorization': 'Bearer {{session('bearer_token')}}'
          },
        }).done((response) => {
          toastr.success('File Deleted.', 'Success!');
          setTimeout(() => {
            location.reload();
          }, 1600);
        }).catch(err => {
          var response = err.responseJSON;
          toastr.error(response.message, 'Error!');
        });
        Swal.fire({
          title: 'File deleted',
          icon: 'success',
          showConfirmButton: false,
          timer: 1000,
        })
      }
      if (result.isDenied) {
        $('div#carousel-files').carousel('cycle')
        Swal.fire({
          title: 'File not deleted',
          icon: 'info',
          showConfirmButton: false,
          timer: 1000,
        })
      }
    })
  }
</script>
@stop
