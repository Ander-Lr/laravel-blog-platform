@extends('layouts.layout')

@push('styles')
@vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<div class="blog-container container">

    <div class="blog-header">
        <h1>Publicaciones</h1>

        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                <a href="{{ route('posts.create') }}" class="btn primary" type="button">Nueva Publicación</a>
            @endif
        @endauth
    </div>

    @if ($message = Session::get('success'))
        <article class="alert-success">
            <p>{{ $message }}</p>
        </article>
    @endif

    <div class="posts-grid">
        @foreach ($posts as $post)
        <article class="post-card">
            <header>

                @if ($post->image)
                    <img src="{{ $post->image }}" alt="{{ $post->title }}" class="post-image">
                @endif

                <h3 class="post-title">{{ $post->title }}</h3>
            </header>

            <p class="post-excerpt">{{ Str::limit($post->content, 150) }}</p>

            <footer class="post-footer">
                <small class="post-meta">
                    Por {{ $post->user->name ?? 'Desconocido' }} el
                    {{ $post->created_at ? $post->created_at->format('d M, Y') : 'Fecha desconocida' }}
                </small>

                <div>

                    <a href="{{ route('posts.show', $post->id) }}" type="button" >Ver</a>

                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                            <a href="{{ route('posts.edit', $post->id) }}" type="button">Editar</a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn danger outline">Eliminar</button>
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
