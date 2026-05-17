<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="logo navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="">
            <span>suplementos hub</span>
            <span class="badge role-badge d-none d-lg-flex">{{ Auth::user()->hasRole('admin') ? 'Admin' : 'Proveedor' }}</span>
        </a>

        <!-- SPACER -->
        <div class="ms-auto"></div>

        <!-- LOGOUT BUTTON -->
        <button id="logout-btn" class="btn btn-outline-secondary btn-sm me-2">
            Salir
        </button>

        <!-- MOBILE BUTTON -->
        <button class="navbar-toggler d-md-none p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>