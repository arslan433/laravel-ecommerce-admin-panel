<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Sidebar Navigation
    |--------------------------------------------------------------------------
    |
    */
    'items' => [
        [
            'label' => 'Dashboard',
            'icon' => 'fa-solid fa-home',              // Font Awesome icon
            'route' => 'admin.dashboard',
            'active_pattern' => 'admin.dashboard',
            
        ],
        [
            'label' => 'User Management',
            'icon' => 'fa-solid fa-users',
            'active_pattern' => 'admin.users.*',
            'children' => [
                [
                    'label' => 'All Users',
                    'route' => 'admin.users.index',
                    'active_pattern' => 'admin.users.index',
                     'permission' => 'user-index'
                ],
                [
                    'label' => 'Roles',
                    'route' => 'admin.roles.index',
                    'active_pattern' => ['admin.roles.*'],
                     'permission' => 'role-index'
                ],
                [
                    'label' => 'Permissions',
                    'route' => 'admin.permissions.index',
                    'active_pattern' => ['admin.permissions.*'],
                    'permission' => 'permission-index'
                ],
            ],
        ],
        // [
        //     'label' => 'Content',
        //     'icon' => 'fa-solid fa-file-lines',
        //     'active_pattern' => 'admin.posts.*',
        //     'children' => [
        //         [
        //             'label' => 'Posts',
        //             'route' => 'admin.posts.index',
        //             'active_pattern' => 'admin.posts.*',
        //         ],
        //         [
        //             'label' => 'Categories',
        //             'route' => 'admin.categories.index',
        //             'active_pattern' => 'admin.categories.*',
        //         ],
        //     ],
        // ],
        [
            'label' => 'Languages',
            'icon' => 'fa-solid fa-gear',
            'route' => 'admin.languages.index',
            'active_pattern' => 'admin.languages',
            'permission' => 'language-index'
        ],
    ],
];
