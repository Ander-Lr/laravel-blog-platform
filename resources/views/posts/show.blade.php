@extends('layouts.app')

@section('content')
<article class="container">

    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    <footer>
        <small>Autor: {{ $post->user->name ?? 'Anónimo' }}</small>
    </footer>

    <hr>

    <h3>Comentarios</h3>

    @foreach ($post->comments as $comment)
        <p>{{ $comment->content }}</p>
        <small>
            @if ($comment->user)
                {{ $comment->user->name }}
            @else
                {{ $comment->guest_name }} (invitado)
            @endif
        </small>
        <hr>
    @endforeach

    <h3>Agregar comentario</h3>
    <form method="POST" action="{{ route('comments.store', $post) }}">
        @csrf

        <label for="content">Comentario:</label>
        <textarea name="content" required></textarea>

        @guest
            <label>Nombre:</label>
            <input type="text" name="guest_name" required>

            <label>Email:</label>
            <input type="email" name="guest_email">
        @endguest

        <button type="submit">Enviar comentario</button>
    </form>

</article>
@endsection
