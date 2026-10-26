@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Eventos</h1>
        <a href="{{ route('eventos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Crear evento
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Organizador</th>
                            <th>Fecha</th>
                            <th>Lugar</th>
                            <th class="text-end">Presupuesto</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eventos as $evento)
                            <tr>
                                <td>{{ $evento->nombre }}</td>
                                <td>{{ $evento->organizador->nombre }}</td>
                                <td>{{ $evento->fecha->format('d/m/Y') }}</td>
                                <td>{{ $evento->lugar }}</td>
                                <td class="text-end">{{ number_format($evento->presupuesto, 0, ',', '.') }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square me-1"></i>Editar
                                    </a>
                                    <form action="{{ route('eventos.destroy', $evento) }}" method="post" class="d-inline"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash me-1"></i>Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Todavía no hay eventos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($eventos->hasPages())
            <div class="card-footer">
                {{ $eventos->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@stop
