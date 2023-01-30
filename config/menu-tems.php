<?php

return [
    'title' => '',
    'title_class' => '',

    'items' => [

        /**
         * 'type': Podem ser: menu-item/sidebar-divider/sidebar-heading. Caso ausente, o item será ignorado.
         * 'sidebar-heading' -> espera a chave label, caso ausente, o item será ignorado.
         * 'sidebar-divider' -> não exige nenhum valor.
         * 'menu-item'       -> Itens esperados: url, icon, label, sub_items.
         */

        ['type' => 'sidebar-divider'],

        /* *
        [
            'type' => 'sidebar-heading',
            'label' => 'Sidebar Heading',
            'icon' => 'fas fa-fw fa-folder',
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
            'type' => 'sidebar-heading',
            'label' => 'Financeiro',
            'icon' => 'fas fa-fw fa-folder',
        ],
        [
            'type' => 'menu-item',
            'route' => null,
            // 'route' => 'admin.dashboard',
            'url' => '#!',
            'class' => 'my-class',
            'icon' => 'fas fa-fw fa-folder',
            'label' => 'Credores',
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
        [
            'type' => 'menu-item',
            'route' => null,
            // 'route' => 'admin.dashboard',
            'url' => '#!',
            'icon' => 'fas fa-fw fa-chart-area',
            'label' => 'Pagamentos',
            'class' => '',

            'can' => [], // Permissões
            'sub_items' => [
                [
                    'type' => 'menu-item',
                    'route' => 'admin.contas.index',
                    'url' => '#!',
                    'label' => 'Lista',
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

        ['type' => 'sidebar-divider'],
    ]
];
