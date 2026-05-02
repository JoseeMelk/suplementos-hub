<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title', 'Auth') — Suplementos Hub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/nav/nav-auth.css')
    @vite('resources/css/nav/nav-logo.css')

    <style>
        body {
            background: #f7f7f5;
            font-family: 'DM Sans', sans-serif;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid #e0dfd8;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        @media (min-width: 576px) {
            .auth-card {
                padding: 28px;
            }
        }

        .btn-main {
            background: #0F6E56;
            color: #fff;
            border-radius: 8px;
        }

        .btn-main:hover {
            background: #085041;
            color: #fff;
        }
    </style>

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.nav-auth')
    
    <main class="flex-grow-1 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card">
            <h2 class="text-center mb-3 fw-semibold font-dm-serif" style="font-size: clamp(1.25rem, 5vw, 1.75rem);">
                suplementos hub
            </h2>

            @yield('content')
        </div>
    </main>

    @include('partials.footer')

    @include('partials.js-config')

    @stack('scripts')
</body>

</html>
