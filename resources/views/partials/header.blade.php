<header class="app-header">

    <div class="app-header-brand">
        <a href="{{ url('/') }}">
            {{ config('app.name', 'بولت ژورنال') }}
        </a>
    </div>

    <div class="app-header-user">

        @auth
            <span class="app-user-name">
                {{ Auth::user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="app-logout">
                    خروج
                </button>
            </form>
        @else

            @if (Route::has('login'))
                <a href="{{ route('login') }}">ورود</a>
            @endif

            @if (Route::has('register'))
                <a href="{{ route('register') }}">ثبت‌نام</a>
            @endif

        @endauth

    </div>

</header>


@if($errors->any())
    <div class="app-alert app-alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if(session('success'))
    <div class="app-alert app-alert-success">
        {{ session('success') }}
    </div>
@endif