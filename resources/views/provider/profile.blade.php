@extends('layouts.provider')

@section('title', 'Mi Perfil')

@section('breadcrumb', 'Mi Perfil')

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <!-- Título y descripción -->
        <div>
            <h4 class="font-dm-serif mb-1">Mi Perfil</h4>
            <p class="text-muted small mb-0 d-none d-md-flex">Administra tu información y genera tu catálogo público</p>
        </div>
    </div>

    <!-- DATOS DEL PROVEEDOR -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-dm-serif">Datos de tu Perfil</h5>
            <button class="btn btn-sm btn-outline-primary" disabled title="Próximamente">
                <i class="bi-pencil me-1"></i>
                Editar
            </button>
        </div>

        <div class="card-body">
            <div class="row g-4">

                <!-- Foto de Perfil -->
                <div class="col-12 col-md-3 text-center">
                    <div class="mb-3">
                        <img src="{{ auth()->user()->avatar ?? 'https://wallpapers.com/images/high/cute-avatar-profile-picture-23yuqpb8wz1dqqqv.webp' }}" 
                             class="rounded-circle border border-2" 
                             style="width: 150px; height: 150px; object-fit: cover;" 
                             alt="Foto de perfil">
                    </div>
                    <p class="text-muted small">Foto de perfil</p>
                </div>

                <!-- Información -->
                <div class="col-12 col-md-9">
                    <div class="row g-3">

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Nombre Completo</label>
                            <p class="fw-semibold">{{ auth()->user()->display_name ?? auth()->user()->name }}</p>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Email</label>
                            <p class="fw-semibold">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Estado de Cuenta</label>
                            <p>
                                @switch(auth()->user()->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @break
                                    @case('approved')
                                        <span class="badge bg-success">Aprobado</span>
                                    @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Rechazado</span>
                                    @break
                                @endswitch
                            </p>
                        </div>

                        <!-- Fecha de Registro -->
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Miembro desde</label>
                            <p class="fw-semibold">{{ auth()->user()->created_at->format('d \d\e F, Y') }}</p>
                        </div>

                        <!-- Bio -->
                        @if(auth()->user()->bio)
                            <div class="col-12">
                                <label class="form-label text-muted small">Descripción</label>
                                <p class="text-muted">{{ auth()->user()->bio }}</p>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- CATÁLOGO PÚBLICO -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-light">
            <h5 class="mb-0 font-dm-serif">Mi Catálogo Público</h5>
        </div>

        <div class="card-body">
            <p class="text-muted mb-4">Genera un enlace único para compartir tu catálogo de productos con clientes</p>

            <div class="row g-3">

                @if(!auth()->user()->slug)
                    <!-- Estado del Slug (Sin generar) -->
                    <div class="col-12">
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi-info-circle me-2"></i>
                            <span>Aún no has generado tu catálogo público. <strong>Crea uno para empezar a compartir.</strong></span>
                        </div>
                    </div>

                    <!-- Input del Slug (deshabilitado) -->
                    <div class="col-12 col-md-8">
                        <label class="form-label text-muted small">Tu enlace de catálogo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">suplementos-hub.com/catalogo/</span>
                            <input type="text" class="form-control" placeholder="Se generará automáticamente" disabled>
                        </div>
                        <small class="text-muted d-block mt-2">El slug se generará basado en tu nombre</small>
                    </div>

                    <!-- Botón Generar Slug -->
                    <div class="col-12 col-md-4 d-flex align-items-end">
                        <button class="btn btn-success w-100" id="btnGenerateSlug" disabled title="Próximamente">
                            <i class="bi-sparkles me-1"></i>
                            Generar Catálogo
                        </button>
                    </div>
                @else
                    <!-- Estado del Slug (Generado) -->
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            <h6 class="mb-2">
                                <i class="bi-check-circle me-1"></i>
                                ¡Catálogo generado!
                            </h6>
                            <p class="mb-0">Tu catálogo está disponible en:</p>
                        </div>
                    </div>

                    <!-- Input del Slug (generado) -->
                    <div class="col-12">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" value="{{ url('/catalogo/' . auth()->user()->slug) }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="btnCopyLink">
                                <i class="bi-clipboard me-1"></i>
                                Copiar
                            </button>
                        </div>
                    </div>

                    <!-- Botón para regenerar -->
                    <div class="col-12">
                        <button class="btn btn-sm btn-outline-warning" id="btnRegenerateSlug" disabled title="Próximamente">
                            <i class="bi-arrow-clockwise me-1"></i>
                            Regenerar Catálogo
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Por el momento sin lógica
        const btnGenerateSlug = document.getElementById('btnGenerateSlug');
        if (btnGenerateSlug) {
            btnGenerateSlug.addEventListener('click', () => {
                alert('Funcionalidad disponible próximamente');
            });
        }
    </script>
@endpush
