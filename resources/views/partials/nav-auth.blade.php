<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container-fluid">
        
        <!-- LOGO -->
        <a class="logo navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="/">
            <span>suplementos hub</span>
        </a>

        <!-- SPACER -->
        <div class="ms-auto d-none d-lg-block"></div>

        <!-- LINKS DESKTOP -->
        <div class="d-none d-lg-flex align-items-center gap-3 me-2">
            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                Crear cuenta
            </a>
        </div>

        <!-- MOBILE BUTTON -->
        <button class="navbar-toggler d-lg-none p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navAuthOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>

<!-- OFFCANVAS MOBILE -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="navAuthOffcanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column gap-2 p-3">
        <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
            Iniciar sesión
        </a>
        <a href="{{ route('register') }}" class="btn btn-success w-100">
            Crear cuenta
        </a>
    </div>
</div>