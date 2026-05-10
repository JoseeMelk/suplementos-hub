@extends('layouts.public')

@section('title', 'Catálogo - ' . $provider->display_name)

@section('content')

    <div class="mb-4">
        <h4 class="fw-semibold mb-1">{{ $provider->display_name }}</h4>
        <p class="text-muted small">Catálogo de productos disponibles</p>
    </div>

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
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4" id="paginationContainer" style="display: none;">
        
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailTitle">Detalles del Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Imagen -->
                        <div class="col-md-6">
                            <img id="productDetailImage" src="" alt="Producto" class="img-fluid rounded" style="max-height: 400px; object-fit: cover; width: 100%;">
                        </div>

                        <!-- Detalles -->
                        <div class="col-md-6">
                            <h5 id="productDetailName" class="fw-semibold mb-2"></h5>
                            
                            <p id="productDetailCategory" class="text-muted small mb-3"></p>

                            <div class="mb-3">
                                <span id="productDetailPrice" class="h5 text-success fw-bold"></span>
                            </div>

                            <p id="productDetailDescription" class="text-muted"></p>

                            <div class="mt-4">
                                <p class="small text-muted mb-1">
                                    <strong>Estado:</strong> <span class="badge bg-success">Disponible</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
