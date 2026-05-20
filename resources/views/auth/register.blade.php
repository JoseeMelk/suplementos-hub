@extends('layouts.auth.auth')

@section('title', 'Registro')

@section('content')

<h4 class="text-center mb-3 fw-semibold font-dm-serif">
    Crear cuenta
</h4>

<p class="text-center text-muted small mb-4">
    Regístrate como proveedor
</p>

<!-- Alerta de datos reales -->
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <small class="d-block mb-2">
        <strong>⚠️ Datos reales:</strong> Por favor, completa este formulario con información real. 
        Estos datos no podrán ser modificados posteriormente.
    </small>
    <small>
        <strong>📌 Nota importante:</strong> Tu nombre de usuario será visible cuando compartas tu catálogo digital.
    </small>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<form id="registerForm">

    <!-- NAME -->
    <div class="mb-3">
        <label class="form-label small">Nombre Completo</label>
        <input type="text" name="name" class="form-control form-control-sm" placeholder="Juan Pérez" required>
    </div>

    <div class="mb-3">
        <label class="form-label small">Nombre de usuario</label>
        <input type="text" name="display_name" class="form-control form-control-sm" placeholder="juan_perez" required>
    </div>

    <!-- EMAIL -->
    <div class="mb-3">
        <label class="form-label small">Correo</label>
        <input type="email" name="email" class="form-control form-control-sm" placeholder="tu@email.com" required>
    </div>

    <!-- PASSWORD -->
    <div class="mb-3">
        <label class="form-label small">Contraseña</label>
        <input type="password" name="password" class="form-control form-control-sm" placeholder="Mínimo 8 caracteres" required>
    </div>

    <!-- CONFIRM -->
    <div class="mb-4">
        <label class="form-label small">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Repite tu contraseña" required>
    </div>

    <button type="submit" class="btn btn-main w-100">
        Crear cuenta
    </button>

</form>

<div class="text-center mt-4 small">
    <span class="text-muted">¿Ya tienes cuenta?</span>
    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Inicia sesión</a>
</div>

@endsection
@push('scripts')
@vite('resources/js/auth/register.js')
@endpush