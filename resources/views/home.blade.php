@extends('layouts.layout')

@push('styles')
    {{-- ESTILO PERSONALIZADO --}}
    @vite(['resources/css/layoutcss.css'])
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>¡Bienvenido!, Has iniciado sesión.</h2>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p>Ahora puedes gestionar el contenido de tu blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection