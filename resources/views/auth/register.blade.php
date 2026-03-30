@extends('layouts.auth.auth')

@section('title', 'Registro')

@section('content')

<h4 class="text-center mb-1" style="font-family:'DM Serif Display'">
    Crear cuenta
</h4>

<p class="auth-sub">
    Regístrate como proveedor
</p>

<form id="registerForm">

    <!-- NAME -->
    <div class="mb-3">
        <label class="form-label small">Nombre Completo</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label small">Nombre de usuario</label>
        <input type="text" name="display_name" class="form-control" required>
    </div>

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

    <!-- CONFIRM -->
    <div class="mb-3">
        <label class="form-label small">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-main w-100">
        Crear cuenta
    </button>

</form>

<div class="text-center mt-3 small">
    <span class="text-muted">¿Ya tienes cuenta?</span>
    <a href="{{ route('login') }}">Inicia sesión</a>
</div>

@endsection
@push('scripts')
@vite('resources/js/auth/register.js')
@endpush