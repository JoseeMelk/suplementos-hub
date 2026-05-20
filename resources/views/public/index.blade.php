@extends('layouts.public')

@section('title', 'Inicio')

@section('content')

<!-- Hero Section -->
<section class="py-5 mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-4">Suplementos Hub</h1>
            <p class="lead text-muted mb-4">
                La plataforma digital que permite a proveedores compartir sus catálogos de suplementos de forma fácil y directa con sus clientes.
            </p>
            <div class="d-flex gap-3">
                <a href="{{ route('login') }}" class="btn btn-success btn-lg">Soy Proveedor</a>
                <a href="#caracteristicas" class="btn btn-outline-success btn-lg">Conocer más</a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <div class="bg-success bg-opacity-10 rounded-4 p-5">
                <i class="bi bi-shop" style="font-size: 5rem; color: #198754;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Características -->
<section class="py-5 mb-5" id="caracteristicas">
    <h2 class="text-center mb-5 fw-bold">¿Cómo Funciona Suplementos Hub?</h2>
    
    <div class="row g-4">
        <!-- Característica 1 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-qr-code" style="font-size: 2.5rem; color: #198754;"></i>
                    </div>
                    <h5 class="card-title">Comparte tu Catálogo</h5>
                    <p class="card-text text-muted">
                        Crea tu catálogo digital único con un enlace personalizado que puedas compartir en redes sociales.
                    </p>
                </div>
            </div>
        </div>

        <!-- Característica 2 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-capsule" style="font-size: 2.5rem; color: #198754;"></i>
                    </div>
                    <h5 class="card-title">Gestiona tus Productos</h5>
                    <p class="card-text text-muted">
                        Publica y actualiza fácilmente tus productos: proteínas, pre-entrenos y más.
                    </p>
                </div>
            </div>
        </div>

        <!-- Característica 3 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-link-45deg" style="font-size: 2.5rem; color: #198754;"></i>
                    </div>
                    <h5 class="card-title">Enlace Compartible</h5>
                    <p class="card-text text-muted">
                        Tus clientes acceden directamente a tu catálogo desde cualquier red social.
                    </p>
                </div>
            </div>
        </div>

        <!-- Característica 4 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-image" style="font-size: 2.5rem; color: #198754;"></i>
                    </div>
                    <h5 class="card-title">Imágenes de Calidad</h5>
                    <p class="card-text text-muted">
                        Sube imágenes de tus productos para mostrarlos profesionalmente.
                    </p>
                </div>
            </div>
        </div>

        <!-- Característica 5 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-graph-up" style="font-size: 2.5rem; color: #198754;"></i>
                    </div>
                    <h5 class="card-title">Sin Costos de Compra</h5>
                    <p class="card-text text-muted">
                        No realizamos compras por la plataforma. Tú gestiona tus transacciones directamente.
                    </p>
                </div>
            </div>
        </div>

        <!-- Característica 6 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-speedometer2" style="font-size: 2.5rem; color: #198754;"></i>
                    </div>
                    <h5 class="card-title">Rápido y Simple</h5>
                    <p class="card-text text-muted">
                        Una solución simple y directa para mostrar tus productos sin complicaciones.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cómo funciona para proveedores -->
<section class="py-5 mb-5 bg-light rounded-4 p-5">
    <h2 class="text-center mb-5 fw-bold">3 Pasos para Empezar</h2>
    
    <div class="row g-4">
        <div class="col-md-6 col-lg-4 text-center">
            <div class="mb-3">
                <span class="badge bg-success p-3" style="font-size: 1.5rem;">1</span>
            </div>
            <h5>Regístrate</h5>
            <p class="text-muted">Crea tu cuenta como proveedor en segundos.</p>
        </div>

        <div class="col-md-6 col-lg-4 text-center">
            <div class="mb-3">
                <span class="badge bg-success p-3" style="font-size: 1.5rem;">2</span>
            </div>
            <h5>Publica Productos</h5>
            <p class="text-muted">Agrega tus productos con fotos y descripción.</p>
        </div>

        <div class="col-md-6 col-lg-4 text-center">
            <div class="mb-3">
                <span class="badge bg-success p-3" style="font-size: 1.5rem;">3</span>
            </div>
            <h5>Comparte tu Enlace</h5>
            <p class="text-muted">Distribuye tu catálogo digital en redes sociales.</p>
        </div>
    </div>
</section>

<!-- Categorías de productos -->
<section class="py-5 mb-5">
    <h2 class="text-center mb-5 fw-bold">Productos que Puedes Vender</h2>
    
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-lightning-fill" style="font-size: 3rem; color: #FFA500;"></i>
                    </div>
                    <h5 class="card-title">Pre-Entrenos</h5>
                    <p class="card-text text-muted">
                        Comparte tu variedad de pre-entrenos y potenciadores de energía para tus clientes.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-danger bg-opacity-10">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-heart-fill" style="font-size: 3rem; color: #FF6B6B;"></i>
                    </div>
                    <h5 class="card-title">Proteínas</h5>
                    <p class="card-text text-muted">
                        Publica todos tus tipos de proteínas en polvo y complementos de recuperación muscular.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="py-5 mb-5 text-center">
    <h2 class="fw-bold mb-4">¿Eres Proveedor de Suplementos?</h2>
    <p class="lead text-muted mb-4">Únete a Suplementos Hub y comparte tu catálogo digital ahora.</p>
    <a href="{{ route('register') }}" class="btn btn-success btn-lg">Registrarse como Proveedor</a>
</section>

@endsection
