@extends('adminlte::page')

@section('title', 'Editar evento')

@section('content_header')
    <h1>Editar evento</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @include('admin.eventos.form', [
        'action' => route('eventos.update', $evento),
        'method' => 'PUT',
        'submitLabel' => 'Guardar cambios',
    ])
@stop
