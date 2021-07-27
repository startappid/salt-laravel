<div class="form-group">
  <label for="form-{{$field['name']}}">
    @if($field['label'])
      {{Str::title($field['label'])}}
    @else
      {{Str::title(str_replace('_', ' ', $field['name']))}}
    @endif
    @if(!$field['required'])
    <small class="text-muted">&mdash; Optional</small>
    @endif
  </label>

  <select
    id="form-{{$field['name']}}"
    name="{{$field['name']}}"
    class="custom-select form-control"
    placeholder="{{$field['placeholder']? Str::title($field['placeholder']) : Str::title(str_replace('_', ' ', $field['name']))}}"
  >
  </select>

  @if(isset($field['note']) && $field['note'])
  <small id="form-help-{{$field['name']}}" class="form-text text-muted">{{$field['note']}}</small>
  @endif
  @if ($errors->has($field['name']))
  <small id="form-error-{{$field['name']}}" class="form-text text-danger">
    {{ $errors->first($field['name']) }}
  </small>
  @endif
</div>

@section('js')
@parent
<script>
$(function() {

  const id = "{{$field['option']['value']}}"
  const label = "{{$field['option']['label']}}"

  $("#form-{{$field['name']}}").select2({
    placeholder: "{{$field['placeholder']? Str::title($field['placeholder']) : '--Select--'}}",
    allowClear: true,
    ajax: {
      url: "{{url('/api/v1/'.$field['reference'])}}",
      dataType: 'json',
      delay: 250,
      headers: {
        'Authorization': 'Bearer {{session('bearer_token')}}',
        "Content-Type" : "application/json",
      },
      data: function(params) {
        return {
          search: params.term, // search term
          page: 1
        };
      },
      processResults: function(response, params) {
        const { data } = response
        params.page = params.page || 1;
        data.filter((item) => {
          item.id = item[id]
          item.text = item[label]
        });
        return {
          results: data
        };
      },
      cache: true
    },
    minimumInputLength: 0
  });

  @if(isset($field['value']) && $field['value'])
  $.ajax({
    url: "{{url('/api/v1/'.$field['reference'])}}/{{$field['value']}}",
    headers: {
      'Authorization': 'Bearer {{session('bearer_token')}}'
    },
  })
  .done((response) => {
    const { data } = response
    const option = new Option(data[label], data[id], false, false);
    $("#form-{{$field['name']}}").append(option).trigger('change');
  });
  @endif

})
</script>
@stop
