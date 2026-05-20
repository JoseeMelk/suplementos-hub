<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
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
    </style>

    @stack('styles')
</head>
<body>

@include('partials.nav')

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR DESKTOP -->
        @include('partials.sidebar')

        <!-- MAIN -->
        <main class="col-12 col-md-9 col-lg-10 p-4">
            @yield('content')
        </main>

    </div>
</div>

<!-- SIDEBAR MOBILE -->
@include('partials.sidebar-mobile')

@include('partials.js-config')

@stack('scripts')
@vite('resources/js/auth/logout.js')
@vite('resources/js/layout/sidebar.js')

</body>
</html>