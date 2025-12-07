@extends('layouts.layout')
@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<main class="container">
    <div class="set-before"><a class="btn" href="{{ route('posts.index') }}" role="button">Regresar</a></div>
    <h1>Editar Post</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <article style="background: #fee; padding: 1rem;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </article>
    @endif

    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')

        <label for="title">Título</label>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" required>

        <label for="content">Contenido</label>
        <textarea name="content" rows="8" required>{{ old('content', $post->content) }}</textarea>

        <button type="submit">Actualizar</button>
    </form>

</main>
@endsection
