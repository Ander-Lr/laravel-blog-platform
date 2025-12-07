<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/css/customblog.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="container-blog">
        <header class="header-blog">
            <nav>
                <div>
                    <a href="{{ url('/') }}">Laravel Blog</a>
                </div>
                <div>
                    @guest
                        <a class="btn" href="{{ route('login') }}">Iniciar Sesión</a>
                        <a class="btn" href="{{ route('register') }}">Registrarse</a>
                    @else
                        <span>{{ Auth::user()->name }} <i class="fa-regular fa-user"></i></span>
                        <a class="btn" href="{{ url('/home') }}" role="button">Panel</a>
                    @endguest
                </div>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>