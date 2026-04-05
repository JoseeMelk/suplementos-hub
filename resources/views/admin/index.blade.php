@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
    <style>
        .dropdown-menu {
            position: absolute;
            z-index: 1055;
        }
    </style>
@endpush
@section('content')

    <h4 style="font-family:'DM Serif Display'">Gestión de proveedores</h4>
    <p class="text-muted small">Aprueba o rechaza proveedores</p>

    <!-- STATS -->
    <div class="row g-3 mt-3">

        <div class="col-6 col-md-3">
            <div class="card p-3 border">
                <small class="text-muted">Total proveedores</small>
                <h5 class="text-success">12</h5>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card p-3 border">
                <small class="text-muted">Pendientes</small>
                <h5 class="text-warning">3</h5>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card p-3 border">
                <small class="text-muted">Aprobados</small>
                <h5>8</h5>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card p-3 border">
                <small class="text-muted">Rechazados</small>
                <h5>1</h5>
            </div>
        </div>

    </div>

    <!-- TABLE PENDIENTES -->
    <div class="card mt-4 border-0 shadow-sm">

        <div class="card-header bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
            <strong>Proveedores Pendientes</strong>

            <input type="text" class="form-control form-control-sm w-auto" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Juan Pérez</td>
                        <td class="text-muted small">juan@email.com</td>
                        <td><span class="badge bg-warning text-dark">pending</span></td>
                        <td class="text-end">
                            <div class="d-flex flex-column flex-md-row gap-1 justify-content-end">
                                <button class="btn btn-sm btn-success">Aprobar</button>
                                <button class="btn btn-sm btn-outline-danger">Rechazar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Mostrando 1–1 de 5</small>
            <div class="d-flex gap-1">
                <button class="btn btn-sm btn-success">1</button>
                <button class="btn btn-sm btn-outline-secondary">2</button>
            </div>
        </div>

    </div>

    <!-- TABLE APROBADOS -->
    <div class="card mt-4 border-0 shadow-sm">

        <div class="card-header bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
            <strong>Proveedores Aprobados</strong>

            <input type="text" class="form-control form-control-sm w-auto" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Catálogo</th>
                        <th>Status</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>María López</td>
                        <td class="text-muted small">maria@email.com</td>

                        <td>
                            <span class="badge bg-success">activo</span>
                        </td>

                        <td>
                            <span class="badge bg-success">approved</span>
                        </td>

                        <td class="text-end position-static">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                                    data-bs-boundary="viewport">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 text-warning">
                                            <i class="bi bi-slash-circle"></i>
                                            Desactivar catálogo
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                            <i class="bi bi-person-x"></i>
                                            Desactivar proveedor
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Pedro Gómez</td>
                        <td class="text-muted small">pedro@email.com</td>

                        <td>
                            <span class="badge bg-secondary">inactivo</span>
                        </td>

                        <td>
                            <span class="badge bg-success">approved</span>
                        </td>

                        <td class="text-end position-static">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                                    data-bs-boundary="viewport">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 text-success">
                                            <i class="bi bi-check-circle"></i>
                                            Activar catálogo
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                            <i class="bi bi-person-x"></i>
                                            Desactivar proveedor
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Mostrando 1–2 de 10</small>
            <div class="d-flex gap-1">
                <button class="btn btn-sm btn-success">1</button>
                <button class="btn btn-sm btn-outline-secondary">2</button>
                <button class="btn btn-sm btn-outline-secondary">3</button>
            </div>
        </div>

    </div>

    <!-- TABLE RECHAZADOS -->
    <div class="card mt-4 border-0 shadow-sm">

        <div class="card-header bg-white d-flex flex-column flex-md-row gap-2 justify-content-between align-items-center">
            <strong>Proveedores Rechazados</strong>

            <input type="text" class="form-control form-control-sm w-auto" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Carlos Ruiz</td>
                        <td class="text-muted small">carlos@email.com</td>
                        <td><span class="badge bg-danger">rejected</span></td>

                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Mostrando 1–1 de 3</small>
            <div class="d-flex gap-1">
                <button class="btn btn-sm btn-success">1</button>
            </div>
        </div>

    </div>
@endsection
