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
            @if($description)
            <p class="card-text">{{$description}}</p>
            @endif

            <form method="POST" action="{{url($segments[0])}}" enctype="multipart/form-data" >
              @method('POST')
              @csrf

              @foreach($structures as $field)
                @if($field['display'])
                  @switch($field['type'])
                    @case('number')
                      number
                      @break
                    @case('email')
                      email
                      @break
                    @case('checkbox')
                      checkbox
                      @break
                    @case('color')
                      color
                      @break
                    @case('date')
                      date
                      @break
                    @case('datetime')
                      datetime
                      @break
                    @case('file')
                      file
                      @break
                    @case('hidden')
                      hidden
                      @break
                    @case('image')
                      image
                      @break
                    @case('month')
                      month
                      @break
                    @case('password')
                      password
                      @break
                    @case('radio')
                      radio
                      @break
                    @case('range')
                      range
                      @break
                    @case('tel')
                      tel
                      @break
                    @case('time')
                      time
                      @break
                    @case('url')
                      url
                      @break
                    @case('select')
                      select
                      @break
                    @case('reference')
                      reference (select2)
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
                      @component('forms.text', ['field' => $field])@endcomponent
                  @endswitch
                @endif
              @endforeach
              <div class="btn-group">
                <a class="btn btn-round btn-light" href="{{url($segments[0])}}" role="button"><i class="fa fa-close"></i> Cancel</a>
                <button type="submit" class="btn btn-round btn-success"><i class="fa fa-check"></i> Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ Default ordering table -->
@endsection

@section('js')
<script>
$(document).ready(function() {

});
</script>
@endsection
