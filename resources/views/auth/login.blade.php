@extends('layouts.auth.auth')

@section('title', 'Iniciar sesión')

@section('content')

<h4 class="text-center mb-3 fw-semibold font-dm-serif">
    Bienvenido
</h4>

<p class="text-center text-muted small mb-4">
    Inicia sesión para continuar
</p>

<div class="auth-error alert alert-danger small d-none"></div>
<form id="loginForm">

    <!-- EMAIL -->
    <div class="mb-3">
        <label class="form-label small">Correo</label>
        <input type="email" name="email" class="form-control form-control-sm" placeholder="tu@email.com" required>
    </div>

    <!-- PASSWORD -->
    <div class="mb-3">
        <label class="form-label small">Contraseña</label>
        <input type="password" name="password" class="form-control form-control-sm" placeholder="Tu contraseña" required>
    </div>

    <!-- REMEMBER -->
    <div class="form-check mb-4">
        <input type="checkbox" name="remember" class="form-check-input" id="rememberCheck">
        <label class="form-check-label small" for="rememberCheck">Recordarme</label>
    </div>

    <button type="submit" class="btn btn-main w-100">
        Iniciar sesión
    </button>

</form>

<div class="text-center mt-4 small">
    <span class="text-muted">¿No tienes cuenta?</span>
    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Regístrate</a>
</div>

@endsection

@push('scripts')
@vite('resources/js/auth/login.js')
@endpush