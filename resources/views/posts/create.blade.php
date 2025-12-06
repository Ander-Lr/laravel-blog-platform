@extends('layouts.app')

@section('content')
<main class="container">

    <h1>Crear Post</h1>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <label>Título</label>
        <input type="text" name="title" required>

        <label>Contenido</label>
        <textarea name="content" required></textarea>

        <button type="submit">Guardar</button>
    </form>

</main>
@endsection
