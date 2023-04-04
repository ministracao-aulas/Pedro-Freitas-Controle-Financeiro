<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary bg-lilas sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sistema de Controle</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 my-1" data-action="sidebarToggle"></button>
    </div>

    <hr class="sidebar-divider my-0">

    <x-sb-amin-menu.menu-list />

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" data-action="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card">
        <p class="text-center mb-2 d-none d-md-block">
            <small class="texte-muted">v{{ date('Y.m') }}-beta</small>
        </p>
        <p class="text-center mb-2">
            <small class="texte-muted">
                &copy;{{ date('Y') }}
            </small>
        </p>
    </div>

</ul>
<!-- End of Sidebar -->
