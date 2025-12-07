@extends('layouts.layout')

@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<div class="container">

    <h1>Detalle del Usuario</h1>

    <article>
        <header>
            <h3>{{ $user->name }}</h3>
        </header>

        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Rol:</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Fecha de creación:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
        <p><strong>Última actualización:</strong> {{ $user->updated_at->format('d/m/Y') }}</p>

        <footer style="margin-top: 20px; display:flex; gap:10px;">
            
            {{-- Botón volver --}}
            <a href="{{ route('admin.users.index') }}" role="button" class="secondary">
                Volver
            </a>

            {{-- Si NO es admin, permitir editar/eliminar --}}
            @if($user->role !== 'admin')

                <a href="{{ route('admin.users.edit', $user->id) }}" role="button">
                    Editar
                </a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                      onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="danger outline">
                        Eliminar
                    </button>
                </form>

            @else
                <span style="color: gray; font-size: 0.9em;">
                    (Administrador — No editable)
                </span>
            @endif

        </footer>
    </article>

</div>
@endsection
