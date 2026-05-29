@extends('layouts.provider')

@section('title', 'Productos')

@section('breadcrumb', 'Mis Productos')

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <!-- Título y descripción -->
        <div>
            <h4 class="font-dm-serif mb-1">Gestión de productos</h4>
            <p class="text-muted small mb-0 d-none d-md-flex">Administra tus productos fácilmente</p>
        </div>

        <!-- Botón -->
        <div>
            <button class="btn btn-success btn-sm" id="btnOpenCreateProductModal">
                <i class="bi-plus-circle me-1"></i>
                Nuevo Producto
            </button>
        </div>
    </div>

    <!-- STATS -->
    {{-- <div class="row g-3 mb-4 d-none d-md-flex">

        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Total</small>
                <h5 class="text-primary mb-0">12</h5>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Visibles</small>
                <h5 class="text-success mb-0">3</h5>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Ocultos</small>
                <h5 class="text-danger mb-0">8</h5>
            </div>
        </div>
    </div> --}}


    <!-- FILTROS Y BUSCADOR -->
    <div class="card border-0 shadow-sm mb-4">
        <!-- Header con botón colapsable -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 font-dm-serif">Filtros y buscador</h6>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterCardBody" aria-expanded="false" aria-controls="filterCardBody" id="toggleFilterCard">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>

        <!-- Contenido colapsable -->
        <div id="filterCardBody" class="collapse">
            <div class="card-body">
                <div class="row g-3 align-items-end">

                    <!-- Buscador -->
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Buscar</label>
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre...">
                        <div class="invalid-feedback" id="searchError">
                            El nombre debe tener más de 3 caracteres
                        </div>
                    </div>

                    <!-- Categoría -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Categoría</label>
                        <select id="categoryFilter" class="form-select"></select>
                    </div>

                    <!-- Estado -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Estado</label>
                        <select id="statusFilter" class="form-select"></select>
                    </div>

                    <!-- Botón enviar y reset -->
                    <div class="col-md-2">
                        <div class="d-flex flex-column gap-2 h-100 justify-content-end">
                            <button class="btn btn-outline-success w-100" id="btnFilterSubmit">
                                Filtrar
                            </button>
                            <button class="btn btn-outline-secondary w-100" id="resetFilters">
                                Limpiar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('partials.ads.provider-card')

    <!-- GRID PRODUCTOS -->
    <div class="row g-4" id="productList">
    </div>

    <!-- PAGINACIÓN -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4"
        id="paginationWrapper">

        <!-- Info -->
        <p class="text-muted small mb-0">
            Mostrando <span id="paginationFrom">0</span>–<span id="paginationTo">0</span>
            de <span id="paginationTotal">0</span> productos
        </p>

        <!-- Controles -->
        <nav>
            <ul class="pagination pagination-sm mb-0 shadow-sm rounded">

                <!-- Prev -->
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="bi-chevron-left"></i>
                    </a>
                </li>

                <!-- Página 1 -->
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>

                <!-- Página 2 -->
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>

                <!-- Página 3 -->
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>

                <!-- Ellipsis -->
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>

                <!-- Última -->
                <li class="page-item">
                    <a class="page-link" href="#">10</a>
                </li>

                <!-- Next -->
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="bi-chevron-right"></i>
                    </a>
                </li>

            </ul>
        </nav>

    </div>


    <!-- MODAL CREAR PRODUCTO -->
    <div class="modal fade" id="createProductModal" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Crear producto</h5>
                </div>

                <div class="modal-body">
                    <form id="createProductForm" enctype="multipart/form-data">

                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-12">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre del producto"
                                    required>
                            </div>

                            <!-- Precio -->
                            <div class="col-6 col-lg-3">
                                <label class="form-label">Precio</label>
                                <div data-price-spinner class="input-group" style="max-width: 140px;">
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-price-minus>
                                        <i class="bi-dash"></i>
                                    </button>
                                    <input type="number" name="price" class="form-control form-control-sm text-center price-input" step="0.01" placeholder="0.00" value="0.00" required>
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-price-plus>
                                        <i class="bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Cantidad -->
                            <div class="col-6 col-lg-3">
                                <label class="form-label">Cantidad</label>
                                <div data-quantity-spinner class="input-group" style="max-width: 120px;">
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-quantity-minus>
                                        <i class="bi-dash"></i>
                                    </button>
                                    <input type="number" name="quantity" class="form-control form-control-sm text-center quantity-input" value="1" min="1" required>
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-quantity-plus>
                                        <i class="bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Categoría -->
                            <div class="col-8 col-lg-4">
                                <label class="form-label">Categoría</label>
                                <select name="category_id" class="form-control w-auto" id="categoryProductCreate" required>
                                    <option value="">Seleccionar categoría</option>
                                </select>
                            </div>

                            <!-- Visible -->
                            <div class="col-4 col-lg-2 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_visible" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_visible" value="1"
                                        checked>
                                    <label class="form-check-label">Visible</label>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Descripción del producto"></textarea>
                            </div>

                            <!-- Imagen -->
                            <div class="col-12">
                                <label class="form-label">Imagen</label>
                                <input type="file" name="image" class="form-control" id="createImage">

                                <!-- Preview -->
                                <div class="mt-2 d-none" id="createImagePreviewWrapper">
                                    <img id="createNewImagePreview" class="img-fluid rounded border"
                                        style="max-height: 150px;">
                                </div>
                            </div>

                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning" id="btnCloseCreateProductModal">
                        Cancelar
                    </button>
                    <button class="btn btn-success" id="saveProductBtn">
                        Guardar producto
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!-- MODAL EDITAR PRODUCTO -->
    <div class="modal fade" id="editProductModal" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Editar producto</h5>
                </div>

                <div class="modal-body">
                    <form id="editProductForm" enctype="multipart/form-data">

                        <!-- ID oculto -->
                        <input type="hidden" name="id" id="editProductId">

                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-12">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>

                            <!-- Precio -->
                            <div class="col-6 col-lg-3">
                                <label class="form-label">Precio</label>
                                <div data-price-spinner class="input-group" style="max-width: 140px;">
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-price-minus>
                                        <i class="bi-dash"></i>
                                    </button>
                                    <input type="number" name="price" id="editPrice" class="form-control form-control-sm text-center price-input" step="0.01" required>
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-price-plus>
                                        <i class="bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Cantidad -->
                            <div class="col-6 col-lg-3">
                                <label class="form-label">Cantidad</label>
                                <div data-quantity-spinner class="input-group" style="max-width: 120px;">
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-quantity-minus>
                                        <i class="bi-dash"></i>
                                    </button>
                                    <input type="number" name="quantity" id="editQuantity" class="form-control form-control-sm text-center quantity-input" value="1" min="1" required>
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-quantity-plus>
                                        <i class="bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Categoría -->
                            <div class="col-8 col-lg-3">
                                <label class="form-label">Categoría</label>
                                <select name="category_id" id="editCategory" class="form-control w-auto" required>
                                </select>
                            </div>

                            <!-- Visible -->
                            <div class="col-4 col-lg-3 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_visible" value="0">
                                    <input class="form-check-input" type="checkbox" id="editVisible" name="is_visible"
                                        value="1">
                                    <label class="form-check-label">Visible</label>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                            </div>

                            <!-- Imagen actual -->
                            <div class="col-md-6">
                                <label class="form-label">Imagen actual</label>
                                <div>
                                    <img id="editImagePreview" class="img-fluid rounded border"
                                        style="max-height:150px;">
                                </div>
                            </div>

                            <!-- Nueva imagen -->
                            <div class="col-md-6">
                                <label class="form-label">Nueva imagen</label>
                                <input type="file" name="image" id="editImage" class="form-control">

                                <!-- Preview nueva -->
                                <div class="mt-2 d-none" id="editImagePreviewWrapper">
                                    <img id="editNewImagePreview" class="img-fluid rounded border"
                                        style="max-height:150px;">
                                </div>
                            </div>

                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning" id="btnCloseEditProductModal">
                        Cancelar
                    </button>
                    <button class="btn btn-success" id="updateProductBtn">
                        Actualizar
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .product-card {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .1);
        }

        .modal-content {
            border-radius: 12px;
        }

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

        .font-dm-serif {
            font-family: 'DM Serif Display', serif;
        }

        /* Quitar spinners nativos del input number */
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .quantity-input[type=number] {
            -moz-appearance: textfield;
        }

        .price-input::-webkit-outer-spin-button,
        .price-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .price-input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Cambiar ícono al colapsar/expandir
        const filterCardBody = document.getElementById('filterCardBody');
        const toggleButtonIcon = document.querySelector('#toggleFilterCard i');

        filterCardBody.addEventListener('show.bs.collapse', () => {
            toggleButtonIcon.classList.remove('bi-chevron-down');
            toggleButtonIcon.classList.add('bi-chevron-up');
        });

        filterCardBody.addEventListener('hide.bs.collapse', () => {
            toggleButtonIcon.classList.remove('bi-chevron-up');
            toggleButtonIcon.classList.add('bi-chevron-down');
        });
    </script>
    @vite(['resources/js/provider/product/page/index.js'])
@endpush
