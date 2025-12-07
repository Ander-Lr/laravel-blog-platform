@extends('layouts.layout')

@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')

<div class="container">

    <h2>Detalle del Comentario</h2>

    <article>
        <header>
            <h3>Comentario #{{ $comment->id }}</h3>
        </header>

        <p><strong>Contenido:</strong></p>
        <p>{{ $comment->content }}</p>

        <hr>

        <p><strong>Autor:</strong>
            @if($comment->user)
                {{ $comment->user->name }} (usuario registrado)
            @else
                {{ $comment->guest_name }} (invitado)
            @endif
        </p>

        @if(!$comment->user)
            <p><strong>Email del invitado:</strong> {{ $comment->guest_email ?? 'No proporcionado' }}</p>
        @endif

        <p><strong>Fecha:</strong> {{ $comment->created_at->format('d M, Y H:i') }}</p>

        <hr>

        <p><strong>Publicación asociada:</strong></p>
        <a href="{{ route('posts.show', $comment->post->id) }}" role="button">
            Ver Post: {{ $comment->post->title }}
        </a>

        <br><br>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.comments.edit', $comment->id) }}" role="button" class="secondary">
                Editar
            </a>

            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                  onsubmit="return confirm('¿Seguro que deseas eliminar este comentario?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="outline danger">Eliminar</button>
            </form>

            <a href="{{ route('admin.comments.index') }}" role="button" class="contrast">
                Volver
            </a>
        </div>
    </article>

</div>

@endsection
