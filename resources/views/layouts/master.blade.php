<!doctype html>
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('partials.head')
</head>

<body>
  <!-- <div id="app"> -->
  <div class="container">
    <div class="item item1 header">
      @include('partials.header')
    </div>
    <div class="item item2 aside aside1">
      @include('partials.sidebar')
    </div>
    <div class="item item3 main">
      @yield('content')
    </div>
    <div class="item item5 footer">
      @include('partials.footer')
    </div>
  </div>
  <!-- </div> -->
</body>

</html>