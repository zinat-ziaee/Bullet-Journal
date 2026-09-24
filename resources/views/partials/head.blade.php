  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel='stylesheet'/>
  <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
  <link href="{{ asset('css/header.css') }}" rel="stylesheet">
  <link href="{{ asset('css/month-log.css') }}" rel="stylesheet">
  <link
    href="{{ asset('css/day-log.css') }}?v={{ filemtime(public_path('css/day-log.css')) }}"
    rel="stylesheet">
  <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css" />
  <link href="{{ asset('css/majid-datepicker.css') }}" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/persian-date.js') }}"></script> 
  <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js" ></script>
  <script src="{{ asset('js/common/jalali-datepicker-init.js') }}"></script>
  <script src="{{ asset('js/ful.js') }}" ></script>
  <script>
    window.appRoutes = {
        convertToShamsi: "{{ route('convert_to_shamsi') }}"
    };
  </script>
  <script src="{{ asset('js/common/date-api.js') }}"></script>
  <script src="{{ asset('js/common/editor.js') }}"></script>
  <script src="{{ asset('js/ui/common-ui.js') }}"></script>
  <script src="{{ asset('js/ui/sidebar.js') }}"></script>
  <script src="{{ asset('js/common/log-edit-modal.js') }}"></script>
  <script src="{{ asset('js/api/logs.js') }}"></script>
  @stack('scripts')

 