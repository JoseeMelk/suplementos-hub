<div class="offcanvas offcanvas-start d-md-none me-4" tabindex="-1" id="sidebar">

    <div class="offcanvas-header">
        <h5>Menú</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">

        <p class="sidebar-title">Gestión</p>

        <a href="{{ route('products.index') }}" class="sidebar-link" data-href="{{ route('products.index') }}">
            Mis Productos
            {{-- <span class="badge bg-warning text-dark">3</span> --}}
        </a>

        <a href="{{ route('profiles.index') }}" class="sidebar-link" data-href="{{ route('profiles.index') }}">
            Mi Perfil
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
