<div class="form-group row">
  <input 
      {{ $attributes->merge(['class' => $class ?? '' ]) }}
      id="{{ $name }}"
      type="{{ $type }}"
      class="form-controller"
      name="{{ $name }}"
      placeholder="{{ isset($placholder) ? $placeholder : '' }}"
      value="{{ old($name) ?: (isset($object) ? $object->name : '') }}"
      {{ isset($attributes) ? $attributes : '' }}
  >
</div>