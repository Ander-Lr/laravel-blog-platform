@extends('layouts.layout')

@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<div class="container">

    <div class="grid">
        <div>
            <h1>Gestión de Usuarios</h1>
        </div>

        <div style="text-align: right;">
            <a href="{{ route('admin.users.create') }}" role="button" class="contrast">
                + Crear Usuario
            </a>
        </div>
    </div>

    @if(session('success'))
        <article>
            <p>{{ session('success') }}</p>
        </article>
    @endif

<div class="table-container" 
     style="overflow-y: auto; max-height: 500px; padding: 5px;">

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th style="text-align:right;">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>

                    <td style="text-align:right; display:flex; gap:10px; justify-content:flex-end;">

                        {{-- Ver --}}
                        <a href="{{ route('admin.users.show', $user->id) }}" role="button">
                            Ver
                        </a>

                        {{-- Si NO es admin --}}
                        @if($user->role !== 'admin')

                            {{-- Editar --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}" role="button" class="secondary">
                                Editar
                            </a>

                            {{-- Eliminar --}}
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="outline danger">
                                    Eliminar
                                </button>
                            </form>

                        @else
                            <span style="color: gray; font-size: 0.9em;">
                                (No editable)
                            </span>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>


</div>
@endsection
