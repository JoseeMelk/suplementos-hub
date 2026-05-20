@extends('layouts.provider')

@section('title', 'Mi Perfil')

@section('breadcrumb', 'Mi Perfil')

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="font-dm-serif mb-1">Mi Perfil</h4>
            <p class="text-muted small mb-0 d-none d-md-flex">Administra tu información y genera tu catálogo público</p>
        </div>
    </div>

    {{-- ===== TABS DESKTOP (Bootstrap nativo) ===== --}}
    <ul class="nav nav-tabs mb-0 bg-white d-none d-md-flex" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button"
                role="tab" aria-selected="true">
                <i class="bi-person me-2"></i>Datos Personales
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="catalogo-tab" data-bs-toggle="tab" data-bs-target="#catalogo" type="button"
                role="tab" aria-selected="false">
                <i class="bi-link-45deg me-2"></i>Mi Catálogo
            </button>
        </li>
    </ul>

    {{-- ===== SEGMENTED CONTROL MOBILE (JS manual) ===== --}}
    <div class="d-md-none mb-3">
        <div class="profile-segment">
            <button class="segment-btn active" data-target="datos">
                <i class="bi-person"></i>
                <span>Mis datos</span>
            </button>
            <button class="segment-btn" data-target="catalogo">
                <i class="bi-link-45deg"></i>
                <span>Mi catálogo</span>
            </button>
        </div>
    </div>

    {{-- ===== TABS CONTENT ===== --}}
    <div class="tab-content bg-white p-3 p-md-4 mb-2" id="profileTabsContent"
        style="border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 12px 12px;">

        {{-- TAB 1: DATOS PERSONALES --}}
        <div class="tab-pane fade show active" id="datos" role="tabpanel">

        {{-- =============================================
            FOTO DE PERFIL (FUTURO - COMENTADO)
            ============================================= --}}
            <!--
            <div class="d-flex align-items-center gap-3 mb-4 pb-4" style="border-bottom: 1px solid #f0f0ee;">

                <div class="position-relative">
                    <div id="avatarPreview" class="rounded-circle overflow-hidden"
                        style="width:72px;height:72px;background:#e9ecef;border:2px solid #dee2e6;">
                        {{-- Si tiene foto --}}
                        @if (auth()->user()->profile_photo_url)
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto de perfil"
                                style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{-- Iniciales como fallback --}}
                            <div
                                style="width:100%;height:100%;display:flex;align-items:center;
                                justify-content:center;font-size:24px;font-weight:600;
                                color:#0F6E56;background:#E1F5EE;">
                                {{ strtoupper(substr(auth()->user()->display_name ?? auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Botón superpuesto para cambiar foto --}}
                    <label for="profilePhotoInput"
                        class="position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center"
                        style="width:24px;height:24px;background:#0F6E56;cursor:pointer;border:2px solid #fff;">
                        <i class="bi-camera-fill text-white" style="font-size:10px;"></i>
                    </label>
                    <input type="file" id="profilePhotoInput" accept="image/*" class="d-none">
                </div>

                <div>
                    <p class="fw-semibold mb-0" style="font-size:14px;">
                        {{ auth()->user()->display_name ?? auth()->user()->name }}
                    </p>
                    <p class="text-muted mb-1" style="font-size:12px;">{{ auth()->user()->email }}</p>
                    <label for="profilePhotoInput" class="text-decoration-none"
                        style="font-size:12px;color:#0F6E56;cursor:pointer;">
                        Cambiar foto
                    </label>
                </div>

            </div>
            -->

            <div class="row g-3 g-md-4">

            {{-- =============================================
                    BOTÓN EDITAR (FUTURO - COMENTADO)
                ============================================= --}}
                <!--
                <div class="col-12 d-flex justify-content-end mb-2">
                    <button class="btn btn-sm btn-outline-success" id="btnEditProfile">
                        <i class="bi-pencil me-1"></i>Editar perfil
                    </button>
                </div>
                -->

                <div class="col-6 col-md-6">
                    <p class="profile-label">Nombre Completo</p>
                    {{-- MODO LECTURA --}}
                    <p class="profile-value" id="displayName">
                        {{ auth()->user()->display_name ?? auth()->user()->name }}
                    </p>
                    {{-- MODO EDICIÓN (FUTURO - COMENTADO) --}}
                    <input type="text" class="form-control form-control-sm d-none" id="inputName"
                        value="{{ auth()->user()->display_name ?? auth()->user()->name }}">

                </div>

                <div class="col-6 col-md-6">
                    <p class="profile-label">Email</p>
                    <p class="profile-value" style="word-break: break-all;">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <div class="col-6 col-md-6">
                    <p class="profile-label">Estado de Cuenta</p>
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
                </div>

                <div class="col-6 col-md-6">
                    <p class="profile-label">Miembro desde</p>
                    <p class="profile-value">
                        {{ auth()->user()->created_at->format('d \d\e F, Y') }}
                    </p>
                </div>

                @if (auth()->user()->bio)
                    <div class="col-12">
                        <p class="profile-label">Descripción</p>
                        {{-- MODO LECTURA --}}
                        <p class="text-muted mb-0" style="font-size:14px;" id="displayBio">
                            {{ auth()->user()->bio }}
                        </p>
                        {{-- MODO EDICIÓN (FUTURO - COMENTADO) --}}
                        <textarea class="form-control form-control-sm d-none" id="inputBio" rows="3">{{ auth()->user()->bio }}</textarea>

                    </div>
                @endif

            {{-- =============================================
                BOTONES GUARDAR/CANCELAR EDICIÓN (FUTURO - COMENTADO) 
                ============================================= --}}
                <div class="col-12 d-flex gap-2 d-none" id="editActions">
                    <button class="btn btn-success btn-sm" id="btnSaveProfile">
                        <i class="bi-check2 me-1"></i>Guardar cambios
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="btnCancelEdit">
                        Cancelar
                    </button>
                </div>


            </div>
        </div>


        {{-- TAB 2: MI CATÁLOGO --}}
        <div class="tab-pane fade" id="catalogo" role="tabpanel">

            @if (!auth()->user()->slug)
                {{-- === SIN SLUG === --}}
                <div class="slug-empty-state">
                    <div class="slug-icon-wrap mb-3">
                        <i class="bi-link-45deg"></i>
                    </div>
                    <h6 class="fw-semibold mb-1">Aún no tienes catálogo público</h6>
                    <p class="text-muted small mb-4">
                        Genera tu enlace único para compartir tus productos con clientes.
                        Se creará automáticamente a partir de tu nombre.
                    </p>

                    <div class="slug-preview-box mb-4">
                        <span class="slug-base">suplementos-hub.com/catalogo/</span>
                        <span class="slug-placeholder">tu-nombre</span>
                    </div>

                    <button class="btn btn-success px-4" id="btnGenerateSlug">
                        <i class="bi-sparkles me-2"></i>Generar mi catálogo
                    </button>
                </div>
            @else
                {{-- === CON SLUG === --}}
                <div class="slug-active-card">

                    {{-- Header --}}
                    <div class="slug-active-header">
                        <div class="slug-check-icon">
                            <i class="bi-check2"></i>
                        </div>
                        <div>
                            <p class="slug-active-title">Catálogo activo</p>
                            <p class="slug-active-sub">Visible públicamente para tus clientes</p>
                        </div>
                    </div>

                    {{-- URL --}}
                    <div class="slug-url-row">
                        <div class="slug-url-text">
                            <i class="bi-globe2 me-2 opacity-50" style="font-size: 12px;"></i>
                            <span>{{ url('/catalogo/' . auth()->user()->slug) }}</span>
                        </div>
                        <button class="slug-copy-btn" id="btnCopyLink" data-catalog-url="{{ url('/catalogo/' . auth()->user()->slug) }}" title="Copiar enlace">
                            <i class="bi-clipboard" id="copyIcon"></i>
                        </button>
                    </div>

                    {{-- Acciones --}}
                    <div class="slug-actions">
                        <a href="{{ url('/catalogo/' . auth()->user()->slug) }}" target="_blank"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="bi-box-arrow-up-right me-1"></i>Ver catálogo
                        </a>
                        <button class="btn btn-sm btn-outline-warning" id="btnRegenerateSlug">
                            <i class="bi-arrow-clockwise me-1"></i>Regenerar
                        </button>
                    </div>

                </div>
            @endif

        </div>

    </div>

    @include('partials.ads.provider-card')

@endsection

@push('styles')
    <style>
        /* ---- Labels del perfil ---- */
        .profile-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #999;
            margin-bottom: 2px;
        }

        .profile-value {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a18;
            margin-bottom: 0;
        }

        /* ---- Segmented control mobile ---- */
        .profile-segment {
            display: flex;
            background: #e9ecef;
            border-radius: 50px;
            padding: 3px;
            gap: 2px;
        }

        .segment-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border: none;
            border-radius: 50px;
            background: transparent;
            color: #6c757d;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s ease;
        }

        .segment-btn.active {
            background: #fff;
            color: #1a1a18;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .12);
        }

        /* ---- Slug: estado vacío ---- */
        .slug-empty-state {
            text-align: center;
            padding: 2rem 1rem;
            max-width: 420px;
            margin: 0 auto;
        }

        .slug-icon-wrap {
            width: 56px;
            height: 56px;
            background: #f0f0ee;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 24px;
            color: #888;
        }

        .slug-preview-box {
            background: #f7f7f5;
            border: 1px dashed #ccc;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            word-break: break-all;
        }

        .slug-base {
            color: #999;
        }

        .slug-placeholder {
            color: #0F6E56;
            font-weight: 500;
        }

        /* ---- Slug: estado activo ---- */
        .slug-active-card {
            background: #E1F5EE;
            border: 1px solid #9FE1CB;
            border-radius: 12px;
            padding: 1.25rem;
            max-width: 540px;
        }

        .slug-active-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .slug-check-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            background: #0F6E56;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
        }

        .slug-active-title {
            font-size: 14px;
            font-weight: 600;
            color: #085041;
            margin: 0;
        }

        .slug-active-sub {
            font-size: 12px;
            color: #0F6E56;
            margin: 0;
        }

        .slug-url-row {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .65);
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 12px;
        }

        .slug-url-text {
            flex: 1;
            font-size: 12px;
            color: #085041;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0;
        }

        .slug-copy-btn {
            background: #0F6E56;
            color: #fff;
            border: none;
            border-radius: 6px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .15s;
        }

        .slug-copy-btn:hover {
            background: #085041;
        }

        .slug-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
    </style>
@endpush

@push('scripts')
    @vite('resources/js/provider/profile/update.js')
@endpush
