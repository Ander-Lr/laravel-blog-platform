<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/css/customblog.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-blog">
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

                        {{-- Mostrar Panel solo a admin o editor --}}
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                            <a class="btn" href="{{ url('/home') }}" role="button">Panel</a>
                        @endif

                        {{-- Botón para cerrar sesión --}}
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-danger" type="submit">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endguest

                </div>
        </header>

<main class="content-blog">

    <div class="grid">
        @forelse ($posts as $post)
            <article>
                <header>
                    @if($post->image)
                        <img src="{{ $post->image }}" alt="{{ $post->title }}"
                             style="width: 100%; height: 200px; object-fit: cover;">
                    @endif
                    <h3>{{ $post->title }}</h3>
                </header>

                <p>{{ Str::limit($post->content, 30) }}</p>

                <footer>
                    <small>
                        Por {{ $post->user->name ?? 'Desconocido' }} el 
                        {{ $post->created_at ? $post->created_at->format('d M, Y') : 'Fecha desconocida' }}
                    </small>

                    {{-- BOTONES DE ACCIÓN --}}
                    <div style="margin-top: 10px; display:flex; gap:10px;">

                        {{-- Ver --}}
                        <a href="{{ route('posts.show', $post) }}">
                            Ver
                        </a>

                        @auth
                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                                
                                {{-- Edit --}}
                                <a href="{{ route('posts.edit', $post) }}">
                                    Editar
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        @endauth

                    </div>

                </footer>
            </article>
        @empty
            <article>
                <p>No se encontraron publicaciones.</p>
            </article>
        @endforelse
    </div>

</main>


        <footer class="footer-blog">
            <div class="container">
                <small>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos
                    reservados.</small>
            </div>
        </footer>
    </div>
</body>

</html>