<aside class="col-md-3 col-lg-2 d-none d-md-block p-2 mb-2">
    <div class="bg-white shadow-sm rounded p-3 position-sticky h-100">

        <p class="sidebar-title">Gestión</p>

        <a href="{{ route('products.index') }}" class="sidebar-link" data-href="{{ route('products.index') }}">
            Mis Productos
            {{-- <span class="badge bg-warning text-dark">3</span> --}}
        </a>

        <a href="{{ route('provider.profile') }}" class="sidebar-link" data-href="{{ route('provider.profile') }}">
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

        <button id="logout-btn-desktop-sidebar" class="sidebar-link w-100 text-start border-0 bg-transparent">
            Cerrar sesión
        </button>
    </div>
</aside>
