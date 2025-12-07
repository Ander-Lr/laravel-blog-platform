<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- estilos adicionales -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>

<body>
    <div class="container-blog">
        <div class="header-blog">
            <a class="navbar-brand" href="{{ url('/') }}">Laravel Blog</a>
            <div>
                @guest
                    <a href="{{ route('login') }}" style="color: white; margin-right: 10px;">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" style="color: white;">Registrarse</a>
                @else
                    <span>{{ Auth::user()->name }} <i class="fa-regular fa-user"></i></span>
                    <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                        {{ __('Cerrar Sesión') }}
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>

        <div class="menu-blog">

            <div><a href="{{ route('posts.index') }}">Publicaciones</a></div>

            @auth
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                    
                    <div><a href="">Usuarios</a></div>
                    <div><a href="#">Comentarios</a></div>

                @endif
            @endauth

        </div>


        <div class="content-blog">
            <!-- Contenido dinamico -->
            @yield('content')
        </div>
        <footer class="footer-blog">
            <div class="container">
                <small>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos
                    reservados.</small>
            </div>
        </footer>
    </div>

    <!-- scripts adicionales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>