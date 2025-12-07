@extends('layouts.layout')

@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<div class="container">

    <h1>Editar Comentario</h1>

    <article>
        <header>
            <strong>Comentario ID:</strong> {{ $comment->id }}
        </header>

        <p><strong>Post original:</strong> 
            <a href="{{ route('posts.show', $comment->post->id) }}">
                {{ $comment->post->title }}
            </a>
        </p>
    </article>

    <form method="POST" action="{{ route('admin.comments.update', $comment->id) }}">
        @csrf
        @method('PUT')

        <label for="content">Contenido del comentario</label>
        <textarea name="content" required>{{ old('content', $comment->content) }}</textarea>

        @if(!$comment->user_id)
            {{-- Solo comentarios de invitados tienen nombre y email --}}
            <label for="guest_name">Nombre del invitado</label>
            <input type="text" name="guest_name" value="{{ old('guest_name', $comment->guest_name) }}">

            <label for="guest_email">Email del invitado</label>
            <input type="email" name="guest_email" value="{{ old('guest_email', $comment->guest_email) }}">
        @endif

        <button type="submit">Actualizar Comentario</button>
    </form>

    <br>

    <a href="{{ route('admin.comments.index') }}" role="button" class="secondary">
        ← Volver a comentarios
    </a>

</div>
@endsection
