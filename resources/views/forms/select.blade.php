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
    class="custom-select form-control"
    placeholder="{{$field['placeholder']? Str::title($field['placeholder']) : Str::title(str_replace('_', ' ', $field['name']))}}"
    name="{{ $field['name'] }}"
  >
    <option value="" readonly> -- Select -- </option>
    @foreach($field['options'] as $option)
    <option
      value="{{$option['value']}}"
      @if(in_array($option['value'], $field['options_disabled'])) disabled="disabled" @endif
      @if(isset($field['value']) && $field['value'] && in_array($option['value'], [$field['value']])) selected
      @elseif(in_array($option['value'], [$field['default']])) selected @endif
    >
    {{$option['label']}}
    </option>
    @endforeach
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
