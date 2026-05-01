<nav class="auth-nav bg-white border-bottom">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center py-2">

      <!-- LOGO -->
      <a href="/" class="auth-logo text-decoration-none fw-bold">
        suplementos hub
      </a>

      <!-- LINKS DESKTOP -->
      <div class="d-none d-md-flex align-items-center gap-3">
        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
          Iniciar sesión
        </a>
        <a href="{{ route('register') }}" class="btn btn-success btn-sm">
          Crear cuenta
        </a>
      </div>

      <!-- HAMBURGER MOBILE -->
      <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#navMobileOffcanvas">
        <i class="bi-list"></i>
      </button>

    </div>
  </div>
</nav>

<!-- OFFCANVAS MOBILE -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="navMobileOffcanvas">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title">Menú</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column gap-2 p-3">
    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
      <i class="bi-box-arrow-in-right me-2"></i>
      Iniciar sesión
    </a>
    <a href="{{ route('register') }}" class="btn btn-success w-100">
      <i class="bi-person-plus me-2"></i>
      Crear cuenta
    </a>
  </div>
</div>