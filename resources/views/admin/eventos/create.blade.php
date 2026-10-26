@extends('adminlte::page')

@section('title', 'Crear evento')

@section('content_header')
    <h1>Crear evento</h1>
@stop

@section('content')
    @include('admin.eventos.form', [
        'action' => route('eventos.store'),
        'method' => 'POST',
        'submitLabel' => 'Crear evento',
    ])
@stop
