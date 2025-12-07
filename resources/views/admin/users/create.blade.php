@extends('layouts.layout')

@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<div class="container">

    <h1>Crear Usuario</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <article class="danger">
            <strong>Corrige los siguientes errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </article>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="grid">

            {{-- Nombre --}}
            <label for="name">
                Nombre:
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </label>

            {{-- Email --}}
            <label for="email">
                Email:
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </label>

        </div>

        <div class="grid">

            {{-- Contraseña --}}
            <label for="password">
                Contraseña:
                <input type="password" name="password" id="password" required>
            </label>

            {{-- Confirmación --}}
            <label for="password_confirmation">
                Confirmar Contraseña:
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </label>

        </div>

        {{-- Rol --}}
        <label for="role">
            Rol:
            <select name="role" id="role" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                <option value="lector" {{ old('role') == 'lector' ? 'selected' : '' }}>Lector</option>
            </select>
        </label>

        <br>

        {{-- Botones --}}
        <div class="grid" style="margin-top:20px;">
            <button type="submit" role="button" class="contrast">
                Guardar Usuario
            </button>

            <a href="{{ route('admin.users.index') }}" role="button" class="secondary">
                Cancelar
            </a>
        </div>

    </form>

</div>
@endsection
