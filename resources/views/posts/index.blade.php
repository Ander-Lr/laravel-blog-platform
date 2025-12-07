@extends('layouts.layout')
@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
    <div class="container">
        <div class="grid">
            <div>
                <h1>Publicaciones</h1>
            </div>
            <div style="text-align: right;">
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                        <a href="{{ route('posts.create') }}" role="button">Crear Nueva Publicación</a>
                    @endif
                @endauth

            </div>
        </div>

        @if ($message = Session::get('success'))
            <article>
                <p>{{ $message }}</p>
            </article>
        @endif

        <div class="grid">
            @foreach ($posts as $post)
                <article>
                    <header>
                        @if ($post->image)
                            <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                style="width: 100%; height: 200px; object-fit: cover;">
                        @endif
                        <h3>{{ $post->title }}</h3>
                    </header>
                    <p>{{ Str::limit($post->content, 150) }}</p>
                    <footer>
                        <small>Por {{ $post->user->name ?? 'Desconocido' }} el
                            {{ $post->created_at ? $post->created_at->format('d M, Y') : 'Fecha desconocida' }}</small>
                        <br>
                        <div style="text-align: right;">

                            <a href="{{ route('posts.show', $post->id) }}" role="button" class="btn">Ver</a>

                            @auth

                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'editor')

                                    <a href="{{ route('posts.edit', $post->id) }}" role="button" class="contrast">Editar</a>

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="outline danger">Eliminar</button>
                                    </form>

                                @endif
                            @endauth

                        </div>

                    </footer>
                </article>

            @endforeach
        </div>
    </div>
@endsection