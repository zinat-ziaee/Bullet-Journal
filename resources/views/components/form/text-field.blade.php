<div class="form-group row">
  <input 
      id="{{ $name }}"
      type="{{ $type }}"
      name="{{ $name }}"
      placeholder="{{ $placeholder ?? '' }}"
      value="{{ old($name) ?: ($object->{$name} ?? '') }}"
      {{ $attributes->merge(['class' => 'form-control ' . ($class ?? '')]) }}
  >
</div>

