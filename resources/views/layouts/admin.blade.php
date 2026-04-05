<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — Suplementos Hub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f7f5;
            color: #1a1a18;
        }

        .logo {
            font-family: 'DM Serif Display';
            color: #0F6E56;
        }

        .sidebar-link {
            font-size: 14px;
            color: #6c757d;
            text-decoration: none;
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background: #f8f9fa;
            color: #0F6E56;
        }

        .sidebar-link.active {
            background: #E1F5EE;
            color: #0F6E56;
            font-weight: 500;
            border-left-color: #0F6E56;
        }

        .sidebar-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            padding: 0 16px;
            margin-top: 16px;
        }

        .admin-badge {
            background: #FFF3CD;
            color: #856404;
            font-size: 11px;
        }
    </style>

    @stack('styles')
</head>
<body>

@include('partials.nav-admin')

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR DESKTOP -->
        <aside class="col-md-3 col-lg-2 d-none d-md-block">
            <div class="bg-white border-end h-100">

                <p class="sidebar-title pt-3">Gestión</p>

                <a href="{{ route('users.index') }}" class="sidebar-link active">
                    Proveedores
                    <span class="badge bg-warning text-dark">3</span>
                </a>

                {{-- <a href="#" class="sidebar-link">
                    Productos
                </a> --}}

                {{-- <hr>

                <p class="sidebar-title">Plataforma</p>

                <a href="#" class="sidebar-link">
                    Estadísticas
                </a> --}}

                <hr>

                <button id="logout-btn-desktop-sidebar" class="sidebar-link w-100 text-start border-0 bg-transparent">
                    Cerrar sesión
                </button>

            </div>
        </aside>

        <!-- MAIN -->
        <main class="col-12 col-md-9 col-lg-10 p-4">
            @yield('content')
        </main>

    </div>
</div>

<!-- SIDEBAR MOBILE -->
<div class="offcanvas offcanvas-start d-md-none me-4" tabindex="-1" id="sidebar">

    <div class="offcanvas-header">
        <h5>Menú</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">

        <p class="sidebar-title">Gestión</p>

        <a href="#" class="sidebar-link active">
            Proveedores
            <span class="badge bg-warning text-dark">3</span>
        </a>

        {{-- <a href="#" class="sidebar-link">
            Productos
        </a> --}}

        {{-- <hr>

        <p class="sidebar-title">Plataforma</p>

        <a href="#" class="sidebar-link">
            Estadísticas
        </a> --}}

        <hr>

        <button id="logout-btn-mobile-sidebar" class="sidebar-link w-100 text-start border-0 bg-transparent">
            Cerrar sesión
        </button>

    </div>

</div>

@include('partials.js-config')

@stack('scripts')

</body>
</html>