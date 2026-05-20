@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

<div class="text-center mb-5">
    <h2 class="fw-semibold font-dm-serif mb-2">Bienvenido, {{ Auth::user()->name }}!</h2>
    <p class="text-muted">Selecciona una opción para continuar</p>
</div>

<div class="row g-4 justify-content-center">

    @if($isProvider)
    <!-- CARD PROVEEDOR - MIS PRODUCTOS -->
    <div class="col-md-5">
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm dashboard-card" style="transition: all 0.3s ease;">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-box-seam" style="font-size: 3rem; color: #28a745;"></i>
                    </div>
                    <h5 class="card-title fw-semibold">Mis Productos</h5>
                    <p class="text-muted small mb-0">Gestiona tu catálogo de productos</p>
                </div>
            </div>
        </a>
    </div>

    <!-- CARD PROVEEDOR - MI PERFIL -->
    <div class="col-md-5">
        <a href="{{ route('profiles.index') }}" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm dashboard-card" style="transition: all 0.3s ease;">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 3rem; color: #007bff;"></i>
                    </div>
                    <h5 class="card-title fw-semibold">Mi Perfil</h5>
                    <p class="text-muted small mb-0">Actualiza tu información personal</p>
                </div>
            </div>
        </a>
    </div>
    @endif

    @if($isAdmin)
    <!-- CARD ADMIN - PROVEEDORES -->
    <div class="col-md-5">
        <a href="{{ route('users.index') }}" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm dashboard-card" style="transition: all 0.3s ease;">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: #17a2b8;"></i>
                    </div>
                    <h5 class="card-title fw-semibold">Gestionar Proveedores</h5>
                    <p class="text-muted small mb-0">Aprueba y rechaza solicitudes de proveedores</p>
                </div>
            </div>
        </a>
    </div>
    @endif

</div>

{{-- <div class="text-center mt-5">
    <button id="logout-btn" class="btn btn-outline-danger btn-sm">
        Cerrar sesión
    </button>
</div> --}}

<style>
    .dashboard-card:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-4px);
    }

    .dashboard-card {
        cursor: pointer;
    }
</style>

@endsection
