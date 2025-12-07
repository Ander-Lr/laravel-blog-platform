@extends('layouts.layout')
@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
    <div class="container">
        <div class="set-before"><a class="btn" href="{{ route('posts.index') }}" role="button">Regresar</a></div>
        <h1>Crear Nueva Publicación</h1>

        @if ($errors->any())
            <article>
                <strong>¡Vaya!</strong> Hubo algunos problemas con tu entrada.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </article>
        @endif

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <label for="title">Título</label>
            <input type="text" name="title" id="title" placeholder="Título" required>

            <label for="content">Contenido</label>
            <textarea name="content" id="content" placeholder="Contenido" style="height:150px" required></textarea>

            <label for="image_url">URL de la Imagen</label>
            <input type="text" name="image" id="image" placeholder="URL de la Imagen">
            <button type="submit">Guardar</button>
        </form>
    </div>
@endsection