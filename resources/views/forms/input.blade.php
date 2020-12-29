<div class="form-group">
  <label for="form-{{$field['field']}}">{{Str::title(str_replace('_', ' ', $field['field']))}}
  @if($field['null'] != 'NO')
  <small class="text-muted">&mdash; Optional</small>
  @endif
  </label>
  <input
    type="text"
    maxlength="{{$field['length']}}"
    class="form-control"
    value="{{$field['value']?: @old($field['field'])}}"
    name="{{$field['field']}}"
    id="form-{{$field['field']}}"
    aria-describedby="form-help-{{$field['field']}}"
    placeholder="{{Str::title(str_replace('_', ' ', $field['field']))}}"
    @if($field['null'] == 'NO') required @endif
    @if(isset($readonly) && $readonly === true ) readonly @endif
  >
  @if(isset($field['help_text']) && $field['help_text'])
  <small id="form-help-{{$field['field']}}" class="form-text text-muted">{{$field['help_text']}}</small>
  @endif
  @if ($errors->has($field['field']))
  <small id="form-error-{{$field['field']}}" class="form-text text-danger">
    {{ $errors->first($field['field']) }}
  </small>
  @endif
</div>
