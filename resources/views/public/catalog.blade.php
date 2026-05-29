@extends('layouts.public')

@section('title', 'Catálogo - ' . $provider->display_name)

@section('content')

    <div class="mb-4">
        <h4 class="fw-semibold mb-1">{{ $provider->display_name }}</h4>
        <p class="text-muted small">Catálogo de productos disponibles</p>
    </div>

    @include('partials.ads.banner')
    
    <!-- GRID PRODUCTOS -->
    <div class="row g-4 mb-4" id="productGrid" data-slug="{{ $slug }}">
        <!-- Los productos se cargarán aquí dinámicamente -->
    </div>

    <!-- ESTADO VACÍO -->
    <div id="emptyState" class="text-center py-5 d-none">
        <i class="bi-box-seam" style="font-size: 3rem; color: #ccc;"></i>
        <p class="text-muted mt-3">No hay productos disponibles en este catálogo</p>
    </div>

    <!-- PAGINACIÓN -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4"
        id="paginationContainer" style="display: none;">

        <!-- Info -->
        <p class="text-muted small mb-0">
            Mostrando <span id="paginationFrom">0</span>–<span id="paginationTo">0</span>
            de <span id="paginationTotal">0</span> productos
        </p>

        <!-- Controles -->
        <nav>
            <ul class="pagination pagination-sm mb-0 shadow-sm rounded" id="paginationNav"></ul>
        </nav>

    </div>

    <!-- MODAL DETALLES PRODUCTO -->
    <div class="modal fade" id="productDetailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-md">
            <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">

                {{-- IMAGEN + BOTÓN CERRAR --}}
                <div class="position-relative bg-light">

                    <button type="button"
                        class="btn-close position-absolute top-0 end-0 m-2 z-1 bg-white shadow-sm rounded-circle p-2"
                        data-bs-dismiss="modal">
                    </button>

                    {{-- Con imagen --}}
                    <div id="productDetailImageWrapper"
                        class="d-flex align-items-center justify-content-center overflow-hidden bg-light"
                        style="height: 300px;">
                        <img id="productDetailImage" src="" alt="Producto" class="img-fluid h-100"
                            style="object-fit: contain; width: auto;">
                    </div>

                    {{-- Fallback sin imagen --}}
                    <div id="productDetailNoImage"
                        class="d-none d-flex align-items-center justify-content-center bg-success bg-opacity-10"
                        style="height: 180px;">
                        <i class="bi-box-seam text-success opacity-50 fs-1"></i>
                    </div>

                </div>

                {{-- BODY --}}
                <div class="modal-body p-4">

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span id="productDetailCategory"
                            class="badge rounded-pill text-success bg-success bg-opacity-10 px-3 py-1">
                        </span>
                        <span class="badge bg-success rounded-pill px-3">Disponible</span>
                    </div>

                    <h5 id="productDetailName" class="fw-semibold mb-1 lh-sm"></h5>

                    <p id="productDetailPrice" class="fw-bold mb-3 text-success fs-4"></p>

                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                        <span class="text-muted small">Cantidad disponible:</span>
                        <span id="productDetailQuantity" class="fw-semibold text-primary">0</span>
                    </div>

                    <hr class="text-secondary opacity-25 my-3">

                    <p id="productDetailDescription" class="text-muted mb-0 lh-lg text-break">
                    </p>

                </div>

                {{-- FOOTER --}}
                <div class="px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>

    @vite('resources/js/public/catalog/catalog-page.js')

@endsection

@push('styles')
    <style>
        .pagination .page-link {
            border: none;
            color: #6c757d;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #198754;
            color: #fff;
            border-radius: 6px;
        }

        .pagination .page-link:hover {
            background-color: #f1f3f5;
            color: #000;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            pointer-events: none;
        }

        .pagination {
            padding: 4px;
            background: #fff;
        }

        .product-card {
            transition: all 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .1);
        }
    </style>
@endpush
