@extends('adminlte::page')

@section('title', 'Editar organizador')

@section('content_header')
    <h1>Editar organizador</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @include('admin.organizadores.form', [
        'action' => route('organizadores.update', $organizador),
        'method' => 'PUT',
        'submitLabel' => 'Guardar cambios',
    ])
@stop
