@php ($readonly = isset($readonly)? true: false)
@switch($field['type'])
  @case('number')
    <!-- Default: NUMBER -->
    @component('forms.number', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('email')
    <!-- Default: EMAIL -->
    @component('forms.email', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('checkbox')
    <!-- Default: CHECKBOX -->
    @component('forms.checkbox', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('color')
    <!-- Default: COLOR -->
    @component('forms.color', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('date')
    <!-- Default: DATE -->
    @component('forms.date', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('datetime')
    <!-- Default: DATETIME -->
    @component('forms.datetime', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('file')
    <!-- Default: FILE -->
    @component('forms.file', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('hidden')
    <!-- Default: HIDDEN -->
    @component('forms.hidden', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('image')
    image
    @break
  @case('password')
    <!-- Default: PASSWORD -->
    @component('forms.password', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('radio')
    <!-- Default: RADIO -->
    @component('forms.radio', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('range')
    <!-- Default: RANGE -->
    @component('forms.range', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('tel')
    <!-- Default: TELEPHONE -->
    @component('forms.tel', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('time')
    <!-- Default: TIME -->
    @component('forms.time', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('url')
    <!-- Default: URL -->
    @component('forms.url', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('select')
    <!-- Default: SELECT -->
    @component('forms.select', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('reference')
    <!-- Default: REFERENCE -->
    @component('forms.reference', ['field' => $field, 'readonly' => $readonly])@endcomponent
    @break
  @case('textarea')
    <!-- Default: textarea -->
    @component('forms.textarea', ['field' => $field, 'readonly' => $readonly])@endcomponent
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
    @component('forms.text', ['field' => $field, 'readonly' => $readonly])@endcomponent
@endswitch
