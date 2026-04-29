@extends('layouts.provider')

@section('title', 'Productos')

@section('content')

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
        <div>
            <h4 style="font-family:'DM Serif Display'">Gestión de productos</h4>
            <p class="text-muted small mb-0 d-none d-md-flex">Administra tus productos fácilmente</p>
        </div>

        <button class="btn btn-sm btn-success" id="btnOpenCreateProductModal">
            <i class="bi-plus-circle"></i>
            Nuevo Producto
        </button>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4 d-none d-md-flex">

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
    </div>


    <!-- FILTROS Y BUSCADOR -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <!-- Buscador -->
                <div class="col-md-4">
                    <label class="form-label small text-muted">Buscar</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre...">
                </div>

                <!-- Categoría -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Categoría</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">Todas</option>
                        <option value="1">Suplementos</option>
                        <option value="2">Proteínas</option>
                        <option value="3">Accesorios</option>
                    </select>
                </div>

                <!-- Estado -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Estado</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">Todos</option>
                        <option value="1">Visibles</option>
                        <option value="0">Ocultos</option>
                    </select>
                </div>

                <!-- Botón reset -->
                <div class="col-md-2 d-grid">
                    <button class="btn btn-outline-secondary" id="resetFilters">
                        Limpiar
                    </button>
                </div>

            </div>

        </div>
    </div>

    <!-- GRID PRODUCTOS -->
    <div class="row g-4" id="productList">

        @for ($i = 0; $i < 6; $i++)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm product-card">

                    <!-- Imagen -->
                    <div class="position-relative">
                        <img src="https://misterfitness.com.mx/img/p/5/0/50-large_default.jpg" class="card-img-top"
                            alt="Producto">

                        <!-- Badge -->
                        <span class="badge bg-success position-absolute top-0 end-0 m-2">
                            Visible
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column">

                        <h6 class="fw-semibold mb-1">Nombre del producto</h6>

                        <span class="text-success fw-bold mb-2">$100.00</span>

                        <p class="text-muted small mb-3">
                            Descripción breve del producto para mostrar información relevante.
                        </p>

                        <!-- Acciones -->
                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi-pencil"></i>
                                Editar
                            </button>
                            <button class="btn btn-sm btn-outline-danger w-100">
                                <i class="bi-trash"></i>
                                Eliminar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endfor

    </div>

    <!-- PAGINACIÓN -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4"
        id="paginationWrapper">

        <!-- Info -->
        <p class="text-muted small mb-0">
            Mostrando <span id="paginationFrom">1</span>–<span id="paginationTo">6</span>
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
    <div class="modal fade" id="createProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Crear producto</h5>
                </div>

                <div class="modal-body">
                    <form id="createProductForm" enctype="multipart/form-data">

                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Nombre del producto" required>
                            </div>

                            <!-- Precio -->
                            <div class="col-md-6">
                                <label class="form-label">Precio</label>
                                <input type="number" name="price" class="form-control" step="0.01"
                                    placeholder="0.00" required>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Descripción del producto"></textarea>
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-6">
                                <label class="form-label">Categoría</label>
                                <select name="category_id" class="form-control" id="categoryProductCreate" required>
                                    <option value="">Seleccionar categoría</option>
                                </select>
                            </div>

                            <!-- Visible -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch mt-3">
                                    <!-- Si NO se marca, se envía el "0" -->
                                    <input type="hidden" name="is_visible" value="0">
                                    <!-- Si SE marca, este sobrescribe al anterior y envía "1" -->
                                    <input class="form-check-input" type="checkbox" name="is_visible" value="1"
                                        checked>
                                    <label class="form-check-label">Visible</label>
                                </div>
                            </div>

                            <!-- Imagen -->
                            <div class="col-md-6">
                                <label class="form-label">Imagen</label>
                                <input type="file" name="image" class="form-control" id="imageInput">

                                <!-- Preview -->
                                <div class="mt-2 d-none" id="imagePreviewWrapper">
                                    <img id="imagePreview" class="img-fluid rounded border" style="max-height: 150px;">
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
<div class="modal fade" id="editProductModal" tabindex="-1">
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
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>

                        <!-- Precio -->
                        <div class="col-md-6">
                            <label class="form-label">Precio</label>
                            <input type="number" name="price" id="editPrice" class="form-control" step="0.01" required>
                        </div>

                        <!-- Descripción -->
                        <div class="col-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Categoría -->
                        <div class="col-md-6">
                            <label class="form-label">Categoría</label>
                            <select name="category_id" id="editCategory" class="form-control" required>
                                <option value="">Seleccionar categoría</option>
                            </select>
                        </div>

                        <!-- Visible -->
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check form-switch mt-3">
                                <input type="hidden" name="is_visible" value="0">
                                <input class="form-check-input" type="checkbox" id="editVisible" name="is_visible" value="1">
                                <label class="form-check-label">Visible</label>
                            </div>
                        </div>

                        <!-- Imagen actual -->
                        <div class="col-md-6">
                            <label class="form-label">Imagen actual</label>
                            <div>
                                <img id="editImagePreview"
                                    class="img-fluid rounded border"
                                    style="max-height:150px;">
                            </div>
                        </div>

                        <!-- Nueva imagen -->
                        <div class="col-md-6">
                            <label class="form-label">Nueva imagen</label>
                            <input type="file" name="image" id="editImage" class="form-control">

                            <!-- Preview nueva -->
                            <div class="mt-2 d-none" id="editImagePreviewWrapper">
                                <img id="editNewImagePreview" class="img-fluid rounded border" style="max-height:150px;">
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
    </style>
@endpush

@push('scripts')
    @vite(['resources/js/provider/product/page/index.js'])
    @vite(['resources/js/provider/product/page/create.js'])
    @vite(['resources/js/provider/product/page/edit.js'])
    @vite(['resources/js/provider/product/picture-preview.js'])
@endpush
