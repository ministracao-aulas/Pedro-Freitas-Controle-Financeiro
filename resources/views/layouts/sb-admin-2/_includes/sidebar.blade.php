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

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Financeiro
    </div>

    <!-- Nav Item -->
    <li class="nav-item">
        <a
            class="nav-link @isActive('admin.contas.index', '', 'collapsed')"
            href="#"
            data-toggle="collapse"
            data-target="#sidebar_bills"
            aria-expanded="@isActive('admin.contas.index', 'true', 'false')"
            aria-controls="sidebar_bills"
        >
            <i class="fas fa-home"></i>
            <span>Pagamentos</span>
        </a>
        <div
            id="sidebar_bills"
            class="collapse @isActive('admin.contas.index', 'show', '')"
            aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar"
        >
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pagamentos:</h6>
                <a class="collapse-item" href="{{ route('admin.contas.index') }}">Lista</a>
                <a class="collapse-item" href="{{ route('admin.contas.index', [
                    'filter' => [
                        'type' => \App\Models\Bill::TYPE_FIXED,
                    ],
                ]) }}">Lista (fixos)</a>
                <a class="collapse-item" href="#!">Principais</a>
                <a class="collapse-item" href="#!">Cadastrar</a>
                <a class="collapse-item" href="#!">Com contas em atraso</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sidebar_creditors" aria-expanded="true"
            aria-controls="sidebar_creditors">
            <i class="fas fa-fw fa-cog"></i>
            <span>Credores</span>
        </a>
        <div id="sidebar_creditors" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Credores:</h6>
                <a class="collapse-item" href="#!">Lista</a>
                <a class="collapse-item" href="#!">Principais</a>
                <a class="collapse-item" href="#!">Cadastrar</a>
                <a class="collapse-item" href="#!">Com contas em atraso</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-users"></i>
            <span>Colaboradores</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">TIPO DE ACESSO:</h6>
                <a class="collapse-item" href="#cadastropag.index">Cadastro</a>
                <a class="collapse-item" href="">Baixa</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Meses -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree" aria-expanded="true"
            aria-controls="collapseTree">
            <i class="fas fa-users"></i>
            <span>Meses</span>
        </a>
        <div id="collapseTree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">Janeiro</a>
                <a class="collapse-item" href="">Fevereiro</a>
                <a class="collapse-item" href="">Março</a>
                <a class="collapse-item" href="">Abril</a>
                <a class="collapse-item" href="">Maio</a>
                <a class="collapse-item" href="">Junho</a>
                <a class="collapse-item" href="">Julho</a>
                <a class="collapse-item" href="">Agosto</a>
                <a class="collapse-item" href="">Setembro</a>
                <a class="collapse-item" href="">Outubro</a>
                <a class="collapse-item" href="">Novembro</a>
                <a class="collapse-item" href="">Dezembro</a>

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Consultas
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="#calendario.index">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Calendario de Pagamentos</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Administrativo
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Interface</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Componentes:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#sidebar_settings"
            aria-expanded="true"
            aria-controls="sidebar_settings">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Configurações</span>
        </a>
        <div id="sidebar_settings" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sistema:</h6>
                <a class="collapse-item" href="#!">Avançados</a>
                <a class="collapse-item" href="#!">Básicos</a>

                <h6 class="collapse-header">Controle de acesso:</h6>
                <a class="collapse-item" href="#!">Usuários</a>
                <a class="collapse-item" href="#!">Papéis</a>
                <a class="collapse-item" href="#!">Permissões</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
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
