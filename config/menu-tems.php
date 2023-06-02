<?php

use App\Models\Menu;
use App\Modules\Menu\MenuRules\ShowHideOnlyByEnv;

return [
    'title' => '',
    'title_class' => '',
    'show_menu_wip_items' => env('SHOW_MENU_WIP_ITEMS', false),

    'items' => [

        /**
         * 'type': Podem ser: menu-item/sidebar-divider/sidebar-heading. Caso ausente, o item será ignorado.
         * 'sidebar-heading' -> espera a chave label, caso ausente, o item será ignorado.
         * 'sidebar-divider' -> não exige nenhum valor.
         * 'menu-item'       -> Itens esperados: url, icon, label, sub_items.
         */

        /* *
        [
            'type' => 'sidebar-heading',
            'label' => 'Sidebar Heading',
            'icon' => 'fas fa-fw fa-folder',
            'active_if_route_in' => [
                'admin.contas.index',
            ],
        ],
        [
            'type',  // string
            'route', // ?string. Se vier vazio/null usará a regra de 'url'
            'url',   // ?string. Se vier vazio/null "#"
            'icon',  // ?string
            'class', // ?string
            'label', // ?string
            'can',   // ?array, // Permissões

            'sub_items' => [], // array, Pode ou não ter itens

            sub_items.* // ? MenuItem[array]
            sub_items.*.type // ?string menu-item|ollapse-divider|collapse-header

        ],
        /* */

        /* *
        [
            'type' => 'menu-item',
            'route' => null,
            // 'route' => 'admin.dashboard',
            'url' => '#!',
            'class' => 'my-class',
            'icon' => 'fas fa-fw fa-folder',
            'label' => 'Pages Gen',
            'sub_items' => [
                ['type' => 'collapse-divider'],
                [
                    'type' => 'collapse-header',
                    'label' => 'Collapse Header',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    // 'route' => 'admin.dashboard',
                    'url' => '#!',
                    'class' => 'my-class',
                    'icon' => 'fas fa-fw fa-folder',
                    'label' => 'Pages Gen',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Login',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Register',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Forgot Password',
                    'can' => [],
                ],
                ['type' => 'collapse-divider'],
                [
                    'type' => 'collapse-header',
                    'label' => 'Other pages',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => '404 Page',
                    'icon' => 'fas fa-fw fa-folder',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Blank Page',
                    'can' => [],
                ],
            ],
        ],
        /** */

        [
            'type' => 'menu-item',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'route' => 'admin.dashboard',
            'active_if_route_in' => ['admin.dashboard'],
            'label' => 'Dashboard',
        ],

        ['type' => 'sidebar-divider'],
        [
            'type' => 'sidebar-heading',
            'label' => 'Financeiro',
            'icon' => 'fas fa-wallet',
        ],
        [
            'type' => 'menu-item',
            'route' => null,
            // 'route' => 'admin.dashboard',
            'url' => '#!',
            'icon' => 'fas fa-wallet',
            'label' => 'Contas',
            'class' => '',
            'active_if_route_in' => [
                'admin.contas.index',
            ],
            'if_active_class_list' => [
                'active',
            ],

            'can' => [], // Permissões
            'sub_items' => [
                [
                    'type' => 'menu-item',
                    'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Lista',
                    'active_if_route_in' => [
                        'admin.contas.index',
                    ],
                    'if_active_class_list' => [
                        'active',
                        'current-route',
                    ],
                ],

                [
                    'type' => 'menu-item',
                    'route' => 'admin.contas.wip',
                    'label' => 'WIP',
                    'icon' => 'fas fa-fw fa-cogs',
                    'custom_menu_rule' => [
                        [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
                    ],
                ],

                [
                    'type' => 'menu-item',
                    'route' => 'admin.contas.create',
                    'url' => '#!',
                    'label' => 'Cadastrar conta',
                ],
                [
                    'type' => 'menu-item',
                    'route' => 'admin.contas.index',
                    'route_params' => [
                        'filter' => [
                            'type' => \App\Models\Bill::TYPE_FIXED,
                        ],
                    ],
                    'url' => '#!',
                    'label' => 'Lista(fixos)',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Principais',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Cadastrar',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Com contas em atraso',
                ],
            ], //Pode ou não ter itens
        ],
        [
            'type' => 'menu-item',
            'route' => null,
            // 'route' => 'admin.dashboard',
            'url' => '#!',
            'class' => 'my-class',
            'icon' => 'fas fa-fw fa-folder',
            'label' => 'Credores',
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            'custom_menu_rule' => [ // 'can'
                // Pode-se passar um boolean ou um callable que não retorne false|null|0|[]...

                // [Menu::class, 'toShow'],  // Mostra o item
                // fn () => Menu::toShow(),  // Mostra o item
                // Menu::toHide(false),      // Mostra o item

                // [Menu::class, 'toHide'],  // Oculta o item
                // fn () => Menu::toHide(),  // Oculta o item
                // Menu::toShow(false),      // Oculta o item

                // Sem regra, por padrão apresenta o item
            ],
            'sub_items' => [
                [
                    'type' => 'collapse-header',
                    'label' => 'Credores',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Lista',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Principais',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Cadastrar',
                ],
                [
                    'type' => 'menu-item',
                    'route' => null,
                    'url' => '#!',
                    'label' => 'Com contas em atraso',
                ],
            ],
        ],

        ['type' => 'sidebar-divider'],
        [
            'type' => 'sidebar-heading',
            'label' => 'Consultas',
            'icon' => 'fas fa-fw fa-folder',
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
        ],

        [
            'type' => 'menu-item',
            'icon' => 'fas fa-fw fa-calendar-alt',
            'label' => 'Pagamentos agendados',
            'url' => '#!',
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            // 'route' => 'admin.dashboard',
            // 'active_if_route_in' => ['admin.dashboard'],
        ],

        ['type' => 'sidebar-divider'],
        [
            'type' => 'sidebar-heading',
            'label' => 'Gerenciamento',
            'icon' => 'fas fa-fw fa-folder',
        ],

        [
            'type' => 'menu-item',
            'icon' => 'fas fa-id-card-alt',
            'label' => 'Colaboradores',
            'url' => '#!',
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            // 'route' => 'admin.dashboard',
            // 'active_if_route_in' => ['admin.dashboard'],
        ],

        ['type' => 'sidebar-divider'],
        [
            'type' => 'sidebar-heading',
            'label' => 'Administrativo',
            'icon' => 'fas fa-fw fa-folder',
        ],
        [
            'type' => 'menu-item',
            'icon' => 'fas fa-users',
            'label' => 'Usuários',
            'url' => '#!',
            'can' => [],
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            // 'route' => 'admin.dashboard',
            // 'active_if_route_in' => ['admin.dashboard'],
            'sub_items' => [
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Lista',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Cadastrar usuário',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Usuários inativos',
                    'can' => [],
                ],
            ],
        ],

        ['type' => 'sidebar-divider'],
        [
            'type' => 'sidebar-heading',
            'label' => 'Controle de acesso',
            'icon' => 'fas fa-fw fa-folder',
        ],
        [
            'type' => 'menu-item',
            'icon' => 'fas fa-user-shield',
            'label' => 'Papéis',
            'url' => '#!',
            'can' => [],
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            // 'route' => 'admin.dashboard',
            // 'active_if_route_in' => ['admin.dashboard'],
            'sub_items' => [
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Lista',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Cadastrar papél',
                    'can' => [],
                ],
            ],
        ],
        [
            'type' => 'menu-item',
            'icon' => 'fas fa-shield-alt',
            'label' => 'Permissões',
            'url' => '#!',
            'can' => [],
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            // 'route' => 'admin.dashboard',
            // 'active_if_route_in' => ['admin.dashboard'],
            'sub_items' => [
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Lista',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Cadastrar permissão',
                    'can' => [],
                ],
            ],
        ],

        ['type' => 'sidebar-divider'],
        [
            'type' => 'sidebar-heading',
            'label' => 'Configurações',
            'icon' => 'fas fa-fw fa-folder',
        ],
        [
            'type' => 'menu-item',
            'icon' => 'fas fa-users',
            'label' => 'Sistema',
            'url' => '#!',
            'can' => [],
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            // 'route' => 'admin.dashboard',
            // 'active_if_route_in' => ['admin.dashboard'],
            'sub_items' => [
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Avançados',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Básicos',
                    'can' => [],
                ],
            ],
        ],
        [
            'type' => 'menu-item',
            'icon' => 'fas fa-users',
            'label' => 'Personalização',
            'url' => '#!',
            'can' => [],
            'custom_menu_rule' => [
                [ShowHideOnlyByEnv::class, 'showOnlyInDev'],
            ],
            // 'route' => 'admin.dashboard',
            // 'active_if_route_in' => ['admin.dashboard'],
            'sub_items' => [
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Cores',
                    'can' => [],
                ],
                [
                    'type' => 'menu-item',
                    // 'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Estilização',
                    'can' => [],
                ],
            ],
        ]
    ]
];
