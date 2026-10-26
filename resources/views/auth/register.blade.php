@extends('adminlte::auth.auth-page', ['authType' => 'register'])

@section('auth_header', 'Registrar administrador')

@section('auth_body')
    <form action="{{ route('register.store') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Nombre completo" autocomplete="name" required autofocus>
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            @error('name')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Correo electrónico" autocomplete="email" required>
            <div class="input-group-text"><i class="bi bi-envelope"></i></div>
            @error('email')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña (mínimo 8 caracteres)" autocomplete="new-password" required>
            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
            @error('password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="form-control" placeholder="Confirmar contraseña" autocomplete="new-password" required>
            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Crear administrador
            </button>
        </div>
    </form>
@stop

@section('auth_footer')
    <a href="{{ route('login') }}">Ya tengo una cuenta</a>
@stop
