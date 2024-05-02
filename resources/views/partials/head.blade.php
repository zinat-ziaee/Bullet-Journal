<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel='stylesheet'/>
  <link href="{{ asset('css/style-flex.css') }}" rel="stylesheet">
  <link href="{{ asset('css/persian-datepicker.css') }}" rel="stylesheet">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/ful.js') }}"></script>
  <script src="{{ asset('js/persian-datepicker.js') }}"></script>
  <script src="{{ asset('js/persian-date.js') }}"></script> 

  @stack('scripts')

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
