<input
  type="hidden"
  class="form-control"
  value="{{isset($field['value'])? $field['value']: @old($field['name'])}}"
  name="{{$field['name']}}"
  id="form-{{$field['name']}}"
  aria-describedby="form-help-{{$field['name']}}"
  placeholder="{{Str::title(str_replace('_', ' ', $field['name']))}}"
  @if(!$field['required']) required @endif
  @if(isset($readonly) && $readonly === true ) readonly @endif
>
