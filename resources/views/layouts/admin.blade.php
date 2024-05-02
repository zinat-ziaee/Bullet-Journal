<html>

<head>
  <title>BuJo - @yield('title')</title>
  @stack('styles')
  <!-- To include stle links -->
</head>

<body>
  @section('sidebar')
  <!-- This is the common sidebar. -->
  @show

  <div class="container">
    @yield('content')
  </div>
  @stack('scripts')
  <!-- To include script links -->
</body>

</html>