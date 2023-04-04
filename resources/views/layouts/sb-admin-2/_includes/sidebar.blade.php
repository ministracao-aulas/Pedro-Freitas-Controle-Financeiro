<!-- Topbar -->
<nav class="fixed-top navbar navbar-expand navbar-light bg-lilas-top topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link _d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-200 small">{{ $user->name }}</span>
                <img class="img-profile rounded-circle" src="{{ URL::asset('img/perfil.png') }}">

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalPerfil">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-primary"></i>
                    Editar Perfil
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    Sair
                </a>
            </div>
        </li>

    </ul>

</nav>

<!-- Sidebar -->
<ul
    class="navbar-nav bg-gradient-primary bg-lilas sidebar sidebar-dark accordion"
    id="accordionSidebar"
>
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sistema de Controle</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <div class="text-left pl-2 d-none d-md-inline">
        <button class="rounded-circle border-0 my-1 mx-2" data-action="sidebarToggle"></button>
    </div>

    <hr class="sidebar-divider my-0">

    <x-sb-amin-menu.menu-list />

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-left pl-2 d-none d-md-inline">
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
