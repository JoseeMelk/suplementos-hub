<aside class="col-md-3 col-lg-2 d-none d-md-block p-2 mb-2">
    <div class="bg-white shadow-sm rounded p-3 position-sticky h-100">

        <p class="sidebar-title">Gestión</p>

        <a href="{{ route('dashboard') }}" class="sidebar-link" data-href="{{ route('dashboard') }}">
            Dashboard
            {{-- <span class="badge bg-warning text-dark">3</span> --}}
        </a>
        @if (Auth::user()->hasRole('admin'))
            <a href="{{ route('users.index') }}" class="sidebar-link" data-href="{{ route('users.index') }}">
                Proveedores
                {{-- <span class="badge bg-warning text-dark">3</span> --}}
            </a>
        @else
            <a href="{{ route('products.index') }}" class="sidebar-link" data-href="{{ route('products.index') }}">
                Mis Productos
                {{-- <span class="badge bg-warning text-dark">3</span> --}}
            </a>

            <hr>

            <p class="sidebar-title">Perfil</p>

            <a href="{{ route('profiles.index') }}" class="sidebar-link" data-href="{{ route('profiles.index') }}">
                Mi Perfil
            </a>
        @endif


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
