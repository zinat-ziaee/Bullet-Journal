  <form {{ $attributes }} method="POST" action="{{ $action ?? 'javascript:void(0)' }}" class="default-form-class">
    @csrf
    @method($method ?? 'POST')
    {{ $slot }}
  </form>