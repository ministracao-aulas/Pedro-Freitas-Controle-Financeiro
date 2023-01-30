    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item d-none">
        <a
            class="nav-link @isActive('admin.contas.index', '', 'collapsed')"
            href="#"
            data-toggle="collapse"
            data-target="#sidebar_bills"
            aria-expanded="@isActive('admin.contas.index', 'true', 'false')"
            aria-controls="sidebar_bills">
            <i class="fas fa-home"></i>
            <span>Pagamentos</span>
        </a>
        <div
            id="sidebar_bills"
            class="collapse @isActive('admin.contas.index', 'show', '')"
            aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">
                    Pagamentos:
                </h6>
                <a class="collapse-item" href="{{ route('admin.contas.index') }}">
                    Lista
                </a>
                <a class="collapse-item"
                    href="{{ route('admin.contas.index', [
                        'filter' => [
                            'type' => \App\Models\Bill::TYPE_FIXED,
                        ],
                    ]) }}">Lista
                    (fixos)</a>
                <a class="collapse-item" href="#!">Principais</a>
                <a class="collapse-item" href="#!">Cadastrar</a>
                <a class="collapse-item" href="#!">Com contas em atraso</a>
            </div>
        </div>
    </li>

    @foreach ($menuItems as $menuItem)
        @if(gettype($menuItem) != 'object' || get_class($menuItem) != 'App\Modules\Menu\MenuItem')
            @continue
        @endif

        @if($menuItem->type == 'sidebar-divider')
            <!-- Divider -->
            <hr
                class="{{ implode(' ', [
                    'sidebar-divider', ($menuItem->class ?? ''),
                ]) }}"
            >
            @continue
        @endif

        @if($menuItem->type == 'sidebar-heading' && $menuItem->label)
            <!-- Heading -->
            <div
                class="{{ implode(' ', [
                    'sidebar-heading', ($menuItem->class ?? ''),
                ]) }}"
            >
                {{ $menuItem->label }}
            </div>
            @continue
        @endif

        @if($menuItem->type == 'menu-item' && $menuItem->label && $menuItem->url)
            <!-- Nav Item - {{ $menuItem->label }} Menu -->
            @if ($menuItem->sub_items)
                <li class="nav-item">
                    <a
                        class="{{ implode(' ', [
                            'nav-link', 'collapsed', ($menuItem->class ?? ''),
                        ]) }}"
                        href="{{ $menuItem->url ?? '#!' }}"
                        data-toggle="collapse"
                        data-target="#{{ $menuItem->menuItemUid }}"
                        aria-expanded="true"
                        aria-controls="{{ $menuItem->menuItemUid }}"
                    >
                        @if ($menuItem->icon)
                            <i class="{{ $menuItem->icon }}"></i>
                        @endif
                        <span>{{ $menuItem->label }}</span>
                    </a>

                    <div id="{{ $menuItem->menuItemUid }}" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @foreach ($menuItem->sub_items as $subItem)
                                @if (!($subItem->type ?? null))
                                    @continue
                                @endif

                                @if (
                                    \in_array(($subItem->type ?? ''), [
                                        'collapse-divider',
                                        'collapse-header',
                                    ], true)
                                )
                                    @if ($subItem->type == 'collapse-header')
                                        @if ($subItem->label)
                                            <h6 class="collapse-header">
                                                @if ($subItem->url ?? null)
                                                    <a class="collapse-item" href="{{ $subItem->url }}">
                                                        {{ $subItem->label }}:
                                                    </a>
                                                @else
                                                {{ $subItem->label }}:
                                                @endif
                                            </h6>
                                        @endif
                                    @else
                                        <hr class="collapse-divider">
                                    @endif

                                    @continue;
                                @endif

                                @if ($subItem->url ?? null)
                                    <a class="collapse-item" href="{{ $subItem->url }}">
                                    @if ($subItem->icon)
                                        <i class="{{ $subItem->icon }}"></i>
                                    @endif
                                @endif

                                    {{ $subItem->label }}

                                @if ($subItem->url ?? null)
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a
                        class="{{ implode(' ', [
                            'nav-link', ($menuItem->class ?? ''),
                        ]) }}"
                        href="{{ $menuItem->url ?? '#!' }}"
                    >
                        @if ($menuItem->icon)
                            <i class="{{ $menuItem->icon }}"></i>
                        @endif
                        <span>{{ $menuItem->label }}</span>
                    </a>
                </li>
            @endif
            @continue
        @endif
    @endforeach

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
