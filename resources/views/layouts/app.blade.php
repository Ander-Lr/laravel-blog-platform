<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <header class="container">
        <nav>
            <ul><li><a href="{{ route('home') }}">Inicio</a></li></ul>
            <ul>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                    @endif

                    @if(auth()->user()->isEditor() || auth()->user()->isAdmin())
                        <li><a href="{{ route('posts.create') }}">Nuevo Post</a></li>
                    @endif

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button>Salir</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Ingresar</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>


</body>
</html>
