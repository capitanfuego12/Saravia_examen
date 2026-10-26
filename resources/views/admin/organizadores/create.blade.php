@extends('adminlte::page')

@section('title', 'Crear organizador')

@section('content_header')
    <h1>Crear organizador</h1>
@stop

@section('content')
    @include('admin.organizadores.form', [
        'action' => route('organizadores.store'),
        'method' => 'POST',
        'submitLabel' => 'Crear organizador',
    ])
@stop
