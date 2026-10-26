<div class="card">
    <div class="card-body">
        @if ($organizadores->isEmpty())
            <div class="alert alert-warning mb-0" role="alert">
                No hay organizadores registrados. Primero agrega un organizador para poder asociarlo al evento.
            </div>
        @else
            <form action="{{ $action }}" method="post">
                @csrf
                @if ($method !== 'POST')
                    @method($method)
                @endif

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del evento</label>
                    <input type="text" name="nombre" id="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        value="{{ old('nombre', $evento->nombre ?? '') }}" maxlength="255" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="id_organizador" class="form-label">Organizador</label>
                    <select name="id_organizador" id="id_organizador"
                        class="form-select @error('id_organizador') is-invalid @enderror" required>
                        <option value="">Selecciona un organizador</option>
                        @foreach ($organizadores as $organizador)
                            <option value="{{ $organizador->id_organizador }}"
                                @selected((string) old('id_organizador', $evento->id_organizador ?? '') === (string) $organizador->id_organizador)>
                                {{ $organizador->nombre }} — {{ $organizador->empresa }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_organizador')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha"
                        class="form-control @error('fecha') is-invalid @enderror"
                        value="{{ old('fecha', isset($evento) ? $evento->fecha->format('Y-m-d') : '') }}" required>
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="lugar" class="form-label">Lugar</label>
                    <input type="text" name="lugar" id="lugar"
                        class="form-control @error('lugar') is-invalid @enderror"
                        value="{{ old('lugar', $evento->lugar ?? '') }}" maxlength="255" required>
                    @error('lugar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="presupuesto" class="form-label">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto"
                        class="form-control @error('presupuesto') is-invalid @enderror"
                        value="{{ old('presupuesto', $evento->presupuesto ?? '') }}" min="0" step="1" required>
                    @error('presupuesto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" @disabled($organizadores->isEmpty())>
                    <i class="bi bi-check-lg me-1"></i>{{ $submitLabel }}
                </button>
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        @endif
    </div>
</div>
