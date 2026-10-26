<div class="card">
    <div class="card-body">
        <form action="{{ $action }}" method="post">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    class="form-control @error('nombre') is-invalid @enderror"
                    value="{{ old('nombre', $organizador->nombre ?? '') }}" maxlength="255" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="empresa" class="form-label">Empresa</label>
                <input type="text" name="empresa" id="empresa"
                    class="form-control @error('empresa') is-invalid @enderror"
                    value="{{ old('empresa', $organizador->empresa ?? '') }}" maxlength="255" required>
                @error('empresa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" name="telefono" id="telefono"
                    class="form-control @error('telefono') is-invalid @enderror"
                    value="{{ old('telefono', $organizador->telefono ?? '') }}" maxlength="255" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>{{ $submitLabel }}
            </button>
            <a href="{{ route('organizadores.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
