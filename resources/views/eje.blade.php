{{-- Cualquier vista del panel proveedor --}}
@extends('layouts.auth.auth')

@section('title', 'Mis productos')

@section('content')
<!-- HERO -->
<section class="hero py-4">
  <div class="container">
    <div class="col-lg-8">

      <h1 class="fw-semibold" style="font-family:'DM Serif Display';">
        Encuentra suplementos de calidad
      </h1>

      <p class="text-muted small">
        Catálogo verificado de proteínas, creatinas y pre-entrenos.
      </p>

      <div class="row g-2">
        <div class="col-12 col-md">
          <input class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-12 col-md-auto">
          <button class="btn btn-main w-100">Buscar</button>
        </div>
      </div>

      <div class="d-flex flex-wrap gap-3 mt-3 small text-muted">
        <span><strong class="text-success">48</strong> productos</span>
        <span><strong class="text-success">12</strong> proveedores</span>
        <span><strong class="text-success">3</strong> categorías</span>
      </div>

    </div>
  </div>
</section>
    <div class="container my-4">
        <div class="row">

            <!-- SIDEBAR -->
            <aside class="col-lg-3 mb-3">

                <p class="text-uppercase small text-muted">Categorías</p>

                <div class="d-flex flex-lg-column flex-row overflow-auto gap-2 mb-3">
                    <div class="sidebar-item active">Todos</div>
                    <div class="sidebar-item">Proteína</div>
                    <div class="sidebar-item">Creatina</div>
                    <div class="sidebar-item">Pre-entreno</div>
                </div>

                <p class="text-uppercase small text-muted d-none d-lg-block">Proveedores</p>

                <div class="d-none d-lg-flex flex-column gap-1">
                    <div class="sidebar-item">Dr. González</div>
                    <div class="sidebar-item">Lic. Martínez</div>
                    <div class="sidebar-item">NutriSport MX</div>
                </div>

            </aside>

            <!-- MAIN -->
            <main class="col-lg-9">

                <!-- TOP -->
                <div class="d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
                    <span class="text-muted small">48 resultados</span>

                    <select class="form-select form-select-sm w-auto">
                        <option>Más recientes</option>
                        <option>Precio menor</option>
                        <option>Precio mayor</option>
                    </select>
                </div>

                <!-- GRID -->
                <div class="row g-3">

                    <!-- CARD -->
                    <div class="col-6 col-md-6 col-lg-4">
                        <div class="card-custom p-2">

                            <div class="bg-light position-relative d-flex align-items-center justify-content-center"
                                style="aspect-ratio:1;">

                                <span class="badge badge-soft position-absolute top-0 start-0 m-2">
                                    Proteína
                                </span>

                                <span class="badge bg-white text-muted position-absolute bottom-0 end-0 m-2 border">
                                    Dr. González
                                </span>

                                IMG
                            </div>

                            <div class="p-2">
                                <small class="text-muted text-uppercase">Optimum Nutrition</small>

                                <div class="fw-medium small">
                                    Gold Standard Whey
                                </div>

                                <small class="text-muted">
                                    908g · Chocolate
                                </small>

                                <div class="d-flex justify-content-between mt-2">
                                    <span class="price">$950</span>
                                    <small class="text-muted">Ver</small>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- PAGINACIÓN -->
                <div class="d-flex justify-content-center mt-4 gap-2">
                    <button class="btn btn-sm btn-outline-secondary">1</button>
                    <button class="btn btn-sm btn-success">2</button>
                </div>

            </main>

        </div>
    </div>
@endsection
@push('scripts')
@vite('resources/js/auth/logout.js')
@endpush
