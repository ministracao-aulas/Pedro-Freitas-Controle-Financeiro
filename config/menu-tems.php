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
        [
            'type' => 'sidebar-heading',
            'label' => 'Sidebar Heading',
            'icon' => 'fas fa-fw fa-folder',
        ],

        /* *
        [
            'type',  // string
            'route', // ?string. Se vier vazio/null usará a regra de 'url'
            'url',   // ?string. Se vier vazio/null "#"
            'icon',  // ?string
            'class', // ?string
            'label', // ?string
            'can',   // ?array, // Permissões

            sub_items.* // ? MenuItem[array]
            sub_items.*.type // ?string menu-item|ollapse-divider|collapse-header
            // 'collapse_header', // TODO <h6 class="collapse-header">Login Screens:</h6>
            // 'collapse_divider', // TODO <div class="collapse-divider"></div>

            'sub_items' => [], // array, Pode ou não ter itens
        ],
        /* */

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

        [
            'type' => 'menu-item',
            'route' => null,
            // 'route' => 'admin.dashboard',
            'url' => '#!',
            'icon' => 'fas fa-fw fa-chart-area',
            'label' => 'Charts',
            'class' => 'my-class',

            'can' => [], // Permissões
            'sub_items' => [], //Pode ou não ter itens
        ],
    ]
];
