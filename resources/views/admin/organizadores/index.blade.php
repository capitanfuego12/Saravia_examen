@extends('adminlte::page')

@section('title', 'Organizadores')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Organizadores</h1>
        <a href="{{ route('organizadores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Crear organizador
        </a>
    </div>
@stop

@section('content')
    @foreach (['success', 'error'] as $type)
        @if (session($type))
            <div class="alert alert-{{ $type === 'error' ? 'danger' : 'success' }} alert-dismissible fade show" role="alert">
                {{ session($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
    @endforeach

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Teléfono</th>
                            <th class="text-center">Eventos asociados</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($organizadores as $organizador)
                            <tr>
                                <td>{{ $organizador->nombre }}</td>
                                <td>{{ $organizador->empresa }}</td>
                                <td>{{ $organizador->telefono }}</td>
                                <td class="text-center">{{ $organizador->eventos_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('organizadores.edit', $organizador) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square me-1"></i>Editar
                                    </a>
                                    @if ($organizador->eventos_count === 0)
                                        <form action="{{ route('organizadores.destroy', $organizador) }}"
                                            method="post" class="d-inline"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este organizador?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger" disabled
                                            title="Tiene eventos asociados">
                                            <i class="bi bi-trash me-1"></i>Eliminar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Todavía no hay organizadores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($organizadores->hasPages())
            <div class="card-footer">
                {{ $organizadores->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@stop
