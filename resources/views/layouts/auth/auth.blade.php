<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title', 'Auth') — Suplementos Hub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #f7f7f5;
            font-family: 'DM Sans', sans-serif;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid #e0dfd8;
            border-radius: 12px;
            padding: 28px;
        }

        .auth-logo {
            font-family: 'DM Serif Display';
            color: #0F6E56;
            text-align: center;
            margin-bottom: 10px;
        }

        .auth-sub {
            text-align: center;
            font-size: 13px;
            color: #6b6b67;
            margin-bottom: 20px;
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

        .auth-nav {
            background: #fff;
            border-bottom: 1px solid #e0dfd8;
            padding: 12px 0;
        }

        .auth-logo {
            font-family: 'DM Serif Display';
            color: #0F6E56;
            font-size: 18px;
        }

        .auth-link {
            font-size: 13px;
            color: #6b6b67;
            text-decoration: none;
        }

        .auth-link:hover {
            color: #0F6E56;
        }
    </style>

    @stack('styles')
</head>

<body>
    @include('partials.nav-auth')
    <div class="auth-wrapper">
        <div class="auth-card">

            <div class="auth-logo">
                suplementos hub
            </div>

            @yield('content')

        </div>
    </div>
    @include('partials.js-config')

    @stack('scripts')
</body>

</html>
