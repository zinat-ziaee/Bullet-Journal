<!doctype html>
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body>

    <div class="app-layout">

        <header class="app-layout-header">
            @include('partials.header')
        </header>

        <aside class="app-layout-sidebar">
            @include('partials.sidebar')
        </aside>

        <main class="app-layout-main">
            @yield('content')
        </main>

    </div>

</body>

</html>