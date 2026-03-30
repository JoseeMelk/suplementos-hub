@extends('layouts.auth.auth')

@section('title', 'Iniciar sesión')

@section('content')

<h4 class="text-center mb-1" style="font-family:'DM Serif Display'">
    Bienvenido
</h4>

<p class="auth-sub">
    Inicia sesión para continuar
</p>

<div class="auth-error alert alert-danger small d-none"></div>
<form id="loginForm">

    <!-- EMAIL -->
    <div class="mb-3">
        <label class="form-label small">Correo</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <!-- PASSWORD -->
    <div class="mb-3">
        <label class="form-label small">Contraseña</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <!-- REMEMBER -->
    <div class="form-check mb-3">
        <input type="checkbox" name="remember" class="form-check-input">
        <label class="form-check-label small">Recordarme</label>
    </div>

    <button type="submit" class="btn btn-main w-100">
        Iniciar sesión
    </button>

</form>

<div class="text-center mt-3 small">
    <span class="text-muted">¿No tienes cuenta?</span>
    <a href="{{ route('register') }}">Regístrate</a>
</div>

@endsection

@push('scripts')
@vite('resources/js/auth/login.js')
@endpush