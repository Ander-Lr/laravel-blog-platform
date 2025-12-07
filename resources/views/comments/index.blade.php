@extends('layouts.layout')

@push('styles')
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
<div class="container">

    <div class="grid">
        <div>
            <h1>Gestión de Comentarios</h1>
        </div>

        <div style="text-align: right;">
            {{-- Only admin should see this link, optional future feature --}}
            {{-- <a href="{{ route('admin.comments.create') }}" role="button" class="contrast">
                + Crear Comentario
            </a> --}}
        </div>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <article>
            <p>{{ session('success') }}</p>
        </article>
    @endif

    {{-- Scrollable table container --}}
    <div style="max-height: 400px; overflow-y: auto; margin-top: 1rem;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Post</th>
                    <th>Autor</th>
                    <th>Contenido</th>
                    <th>Fecha</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>

                        {{-- Related post title --}}
                        <td>
                            @if($comment->post)
                                {{ Str::limit($comment->post->title, 40) }}
                            @else
                                (Post eliminado)
                            @endif
                        </td>

                        {{-- Author: registered user or guest --}}
                        <td>
                            @if($comment->user)
                                {{ $comment->user->name }}
                            @else
                                {{ $comment->guest_name ?? 'Invitado' }}
                            @endif
                        </td>

                        {{-- Comment content (short) --}}
                        <td>{{ Str::limit($comment->content, 60) }}</td>

                        {{-- Created date --}}
                        <td>
                            {{ $comment->created_at ? $comment->created_at->format('d/m/Y H:i') : '-' }}
                        </td>

                        {{-- Actions --}}
                        <td style="text-align:right; display:flex; gap:10px; justify-content:flex-end;">

                            {{-- View comment detail --}}
                            <a href="{{ route('admin.comments.show', $comment->id) }}" role="button">
                                Ver
                            </a>

                            {{-- Optional: edit comment --}}
                            <a href="{{ route('admin.comments.edit', $comment->id) }}" role="button" class="secondary">
                                Editar
                            </a>

                            {{-- Delete comment --}}
                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este comentario? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="outline danger">
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            No se encontraron comentarios.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
