<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Catálogo') — Suplementos Hub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/nav/nav-logo.css')
    @vite('resources/css/common/typography.css')
    @vite('resources/css/public/catalog.css')

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f7f5;
            color: #1a1a18;
        }

        .pagination .page-item.active .page-link {
            background-color: #198754;
            color: #fff;
            border-radius: 6px;
        }
    </style>

    @stack('styles')
</head>

<body>

    @include('partials.nav-auth')

    <!-- HEADER CATÁLOGO -->
    <div class="header-catalog">
        <div class="container">
            <div class="header-catalog-content">
                <!-- Avatar Provider -->
                <div class="flex-shrink-0 d-none d-md-block">
                    <img src="https://wallpapers.com/images/high/cute-avatar-profile-picture-23yuqpb8wz1dqqqv.webp" 
                         class="provider-avatar" alt="Avatar proveedor">
                </div>

                <!-- Info Provider -->
                <div class="flex-grow-1">
                    <h1 class="font-dm-serif mb-2">Catálogo de Productos</h1>
                    <p class="mb-1 fs-5">Proveedor: <strong>José García</strong></p>
                    <p class="mb-0 text-white-50">Descubre nuestros mejores suplementos y productos de calidad</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main class="container pb-2">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

</body>

</html>
