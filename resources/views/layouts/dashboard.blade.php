<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — Suplementos Hub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/nav/nav-logo.css')
    @vite('resources/css/layout/sidebar.css')

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f7f5;
            color: #1a1a18;
        }

        .layout-row {
            min-height: calc(100vh - 60px - 73px);
        }
    </style>

    @stack('styles')
</head>

<body>

    @include('partials.nav')

    <div class="container-fluid">
        <div class="row align-items-stretch layout-row">

            <!-- SIDEBAR DESKTOP -->
            @include('partials.sidebar')

            <!-- MAIN -->
            <main class="col-12 col-md-9 col-lg-10 p-4 pb-2">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active" aria-current="page">
                        </li>
                    </ol>
                </nav>
                @yield('content')
            </main>

        </div>
    </div>

    <!-- SIDEBAR MOBILE -->
    @include('partials.sidebar-mobile')

    @include('partials.js-config')

    @include('partials.footer')

    @stack('scripts')
    @vite('resources/js/layout/sidebar.js')

</body>

</html>
