@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
    <h1>Panel de administración</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="h5">Bienvenido, {{ auth()->user()->name }}</h2>
            <p class="mb-0">Has iniciado sesión en el sistema de eventos.</p>
            <a href="{{ route('eventos.index') }}" class="btn btn-primary mt-3">
                <i class="bi bi-file-earmark me-1"></i>Gestionar eventos
            </a>
            <a href="{{ route('organizadores.index') }}" class="btn btn-outline-primary mt-3">
                <i class="bi bi-person me-1"></i>Gestionar organizadores
            </a>
        </div>
    </div>
@stop
