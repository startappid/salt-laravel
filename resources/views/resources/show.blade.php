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

              @foreach($structures as $field)
                @if($field['display'])
                  @switch($field['type'])
                    @case('number')
                      <!-- Default: NUMBER -->
                      @component('forms.number', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('email')
                      <!-- Default: EMAIL -->
                      @component('forms.email', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('checkbox')
                      <!-- Default: CHECKBOX -->
                      @component('forms.checkbox', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('color')
                      <!-- Default: COLOR -->
                      @component('forms.color', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('date')
                      <!-- Default: DATE -->
                      @component('forms.date', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('datetime')
                      <!-- Default: DATETIME -->
                      @component('forms.datetime', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('file')
                      <!-- Default: FILE -->
                      @component('forms.file', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('hidden')
                      <!-- Default: HIDDEN -->
                      @component('forms.hidden', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('image')
                      image
                      @break
                    @case('password')
                      <!-- Default: PASSWORD -->
                      @component('forms.password', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('radio')
                      <!-- Default: RADIO -->
                      @component('forms.radio', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('range')
                      <!-- Default: RANGE -->
                      @component('forms.range', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('tel')
                      <!-- Default: TELEPHONE -->
                      @component('forms.tel', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('time')
                      <!-- Default: TIME -->
                      @component('forms.time', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('url')
                      <!-- Default: URL -->
                      @component('forms.url', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('select')
                      <!-- Default: SELECT -->
                      @component('forms.select', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('reference')
                      <!-- Default: REFERENCE -->
                      @component('forms.reference', ['field' => $field, 'readonly' => true])@endcomponent
                      @break
                    @case('slider')
                      slider
                      @break
                    @case('datepicker')
                      datepicker
                      @break
                    @case('datetimepicker')
                      datetimepicker
                      @break
                    @case('timepicker')
                      timepicker
                      @break
                    @default
                      <!-- Default: TEXT -->
                      @component('forms.text', ['field' => $field, 'readonly' => true])@endcomponent
                  @endswitch
                @endif
              @endforeach
              <div class="btn-group">
                <a class="btn btn-round btn-light" href="{{url($segments[0])}}" role="button"><i class="fa fa-close"></i> Cancel</a>
                <button class="btn btn-round text-dark"><a href="{{url(Request::segment(1).'/'.Request::segment(2).'/edit')}}"><i class="fa fa-edit"></i> Edit</a></button>
                <button class="btn btn-round text-delete"><a href="#" class="text-danger form-delete" data-id="{{Request::segment(2)}}"><i class="fa fa-trash"></i> Delete</a></button>
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
