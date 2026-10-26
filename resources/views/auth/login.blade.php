@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('auth_header', 'Iniciar sesión')

@section('auth_body')
    <form action="{{ route('login.store') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Correo electrónico" autocomplete="email" required autofocus>
            <div class="input-group-text"><i class="bi bi-envelope"></i></div>
            @error('email')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña" autocomplete="current-password" required>
            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
            @error('password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="row align-items-center">
            <div class="col-7">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        @checked(old('remember'))>
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
            </div>
            <div class="col-5 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Ingresar
                </button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    <a href="{{ route('register') }}">Registrar un administrador</a>
@stop
