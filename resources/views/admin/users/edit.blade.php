@extends('layouts.layout')

@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<div class="container">

    <h1>Editar Usuario</h1>

    {{-- Flash success message --}}
    @if(session('success'))
        <article>
            <p>{{ session('success') }}</p>
        </article>
    @endif

    {{-- Update form --}}
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nombre:</label>
        <input 
            type="text" 
            name="name" 
            id="name" 
            value="{{ old('name', $user->name) }}" 
            required
        >
        @error('name')
            <small style="color:red;">{{ $message }}</small>
        @enderror

        <label for="email">Email:</label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            value="{{ old('email', $user->email) }}" 
            required
        >
        @error('email')
            <small style="color:red;">{{ $message }}</small>
        @enderror

        <label for="role">Rol:</label>
        <select name="role" id="role" required>
            <option value="admin"   {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="editor"  {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
            <option value="lector"  {{ $user->role === 'lector' ? 'selected' : '' }}>Lector</option>
        </select>
        @error('role')
            <small style="color:red;">{{ $message }}</small>
        @enderror

        <button type="submit" role="button" class="contrast" style="margin-top: 15px;">
            Actualizar Usuario
        </button>

    </form>

    <div style="margin-top: 20px;">
        <a href="{{ route('admin.users.index') }}" role="button">
            Volver a la lista
        </a>
    </div>

</div>
@endsection
