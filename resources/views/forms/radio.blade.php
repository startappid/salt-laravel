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
  <div class="radio-{{$field['inline']? 'inline': 'list'}}">
    @foreach($field['options'] as $option)
    <label class="radio @if(in_array($option['value'], $field['options_disabled'])) radio-disabled @endif">
      <input
        name="{{$field['name']}}"
        value="{{$option['value']}}"
        type="radio"
        @if(in_array($option['value'], $field['options_disabled'])) disabled="disabled" @endif
        @if(in_array($option['value'], [$field['default']])) checked="checked" @endif
      />
      <span></span>
      {{$option['label']}}
    </label>
    @endforeach
  </div>

  @if(isset($field['note']) && $field['note'])
  <small id="form-help-{{$field['name']}}" class="form-text text-muted">{{$field['note']}}</small>
  @endif
  @if ($errors->has($field['name']))
  <small id="form-error-{{$field['name']}}" class="form-text text-danger">
    {{ $errors->first($field['name']) }}
  </small>
  @endif
</div>
