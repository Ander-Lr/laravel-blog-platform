<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- PicoCSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">

    <!-- Tus estilos -->
    @vite(['resources/css/app.css', 'resources/css/customblog.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-blog">

        <!-- HEADER -->
        <header class="header-blog">
            <nav class="nav-blog">
                <div class="brand">
                    <a href="{{ url('/') }}" class="brand-title">Laravel Blog</a>
                </div>

                <div class="user-actions">
                    @guest
                        <a class="btn" href="{{ route('login') }}">Iniciar Sesión</a>
                        <a class="btn" href="{{ route('register') }}">Registrarse</a>
                    @else
                        <span class="user-name">
                            {{ Auth::user()->name }}
                        </span>

                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                            <a class="btn" href="{{ url('/home') }}">Panel</a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button class="btn btn-danger">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endguest
                </div>
            </nav>
        </header>

        <!-- MAIN CONTENT -->
        <main class="content-blog">

            <div class="post-grid">
                @forelse ($posts as $post)
                    <article class="post-card">

                        <header>

                            @if($post->image)
                                <img src="{{ $post->image }}" 
                                     alt="{{ $post->title }}" 
                                     class="post-image">
                            @endif

                            <h3 class="post-title">{{ $post->title }}</h3>
                        </header>

                        <p class="post-excerpt">
                            {{ Str::limit($post->content, 120) }}
                        </p>

                        <footer class="post-footer">
                            <small class="post-meta">
                                Por {{ $post->user->name ?? 'Desconocido' }} ·
                                {{ $post->created_at?->format('d M, Y') ?? 'Fecha desconocida' }}
                            </small>

                        </footer>

                    </article>
                @empty
                    <article>
                        <p>No se encontraron publicaciones.</p>
                    </article>
                @endforelse
            </div>

        </main>

        <!-- FOOTER -->
        <footer class="footer-blog">
            <div class="container">
                <small>&copy; {{ date('Y') }} {{ config('app.name') }} — Todos los derechos reservados.</small>
            </div>
        </footer>

    </div>
</body>

</html>
