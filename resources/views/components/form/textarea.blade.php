@props(['disabled' => false, 'rows'=>'4', 'cols'=>'50'])

<textarea {{ $disabled ? 'disabled' : '' }}  name="{{ $name }}" rows="{{ $rows }}" cols="{{ $cols }}" {!! $attributes->merge(['class' => 'form-input rounded-md shadow-sm']) !!}>
  {!! old($name) ?: (isset($object) ? $object->name : '') !!}  
</textarea>