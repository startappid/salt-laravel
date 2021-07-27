@extends('layouts.metronic.app')
<!-- SUBHEADER::TITLE -->
@section('subheader-title') Export @endsection

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
            <form method="POST" enctype="multipart/form-data" >
              @method('POST')
              @csrf
              <div class="btn-group">
                <a class="btn btn-round btn-light" href="{{url($segments[0])}}" role="button"><i class="fa fa-close"></i> Cancel</a>
                @can(Request::segment(1).'.export.*')
                <button type="submit" class="btn btn-round btn-success"><i class="fa fa-download"></i> Export</button>
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
@endsection

@section('js')
<script>
$(document).ready(function() {

});
</script>
@endsection
