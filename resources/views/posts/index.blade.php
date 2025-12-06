@extends('layouts.app')

@section('content')
<main class="container">
    <h1>Publicaciones</h1>

    @foreach ($posts as $post)
        <article>
            <h2>
                <a href="{{ route('posts.show', $post) }}">
                    {{ $post->title }}
                </a>
            </h2>
            <p>{{ Str::limit($post->content, 150) }}</p>
            <footer>
                <small>Autor: {{ $post->user->name ?? 'Anónimo' }}</small>
            </footer>
        </article>
        <hr>
    @endforeach
</main>
@endsection
