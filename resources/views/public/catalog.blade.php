@extends('layouts.public')

@section('title', 'Catálogo')

@section('content')

    <!-- GRID PRODUCTOS -->
    <div class="row g-4 mb-4">
        <!-- Producto 1 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">Proteína Whey <small class="text-muted">- Proteínas</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $29.99
                    </span>

                    <p class="text-muted small mb-3">
                        Proteína de alta calidad para ganar músculo
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Producto 2 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">Creatina Monohidrato <small class="text-muted">- Energía</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $19.99
                    </span>

                    <p class="text-muted small mb-3">
                        Incrementa fuerza y rendimiento deportivo
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Producto 3 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">Vitaminas Multivitamínico <small class="text-muted">- Vitaminas</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $24.99
                    </span>

                    <p class="text-muted small mb-3">
                        Suplemento completo con 20+ nutrientes
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Producto 4 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">BCAA Aminoácidos <small class="text-muted">- Aminoácidos</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $34.99
                    </span>

                    <p class="text-muted small mb-3">
                        Aminoácidos esenciales para recuperación
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Producto 5 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">Pre-Entreno Energía <small class="text-muted">- Energía</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $39.99
                    </span>

                    <p class="text-muted small mb-3">
                        Potencia y concentración para entrenamientos
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Producto 6 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">Omega 3 Ácidos <small class="text-muted">- Omega</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $22.99
                    </span>

                    <p class="text-muted small mb-3">
                        Ácidos grasos esenciales para salud
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Producto 7 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">Magnesio Mineral <small class="text-muted">- Minerales</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $16.99
                    </span>

                    <p class="text-muted small mb-3">
                        Mineral para relajación y recuperación
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Producto 8 -->
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative">
                    <img src="https://www.befunky.com/images/wp/wp-2018-08-product-photography-24.jpg?auto=avif,webp&format=jpg&width=950" 
                         class="card-img-top"
                         alt="Producto">

                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                        Disponible
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1">Colágeno Hidrolizado <small class="text-muted">- Colágeno</small></h6>

                    <span class="text-success fw-bold mb-2">
                        $27.99
                    </span>

                    <p class="text-muted small mb-3">
                        Para articulaciones y piel saludable
                    </p>

                    <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            Detalles
                        </button>
                        <button class="btn btn-sm btn-outline-success w-100">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- PAGINACIÓN -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4">

        <!-- Info -->
        <p class="text-muted small mb-0">
            Mostrando <span>1</span>–<span>8</span>
            de <span>24</span> productos
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

                <!-- Next -->
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

@endsection
