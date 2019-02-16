<?php

return [
    'module:user' => [
        'key' => 'module:user',
        'route:url' => 'https://localhost.sample/admin/user',
        'route:name' => 'users',
        'text' => 'Users',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'order' => 100,
        'children' => [
            'users.index' => [
                'key' => 'users.index',
                'route:url' => 'https://localhost.sample/admin/user',
                'route:name' => 'users.index',
                'text' => 'All User',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'children' => [
                    'users.roles' => [
                        'key' => 'users.roles',
                        'route:url' => 'https://localhost.sample/admin/user',
                        'route:name' => 'users.roles',
                        'text' => 'All User Roles',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                    ],
                ],
            ],
            'users.create' => [
                'key' => 'users.create',
                'route:url' => 'https://localhost.sample/admin/user/create',
                'route:name' => 'users.create',
                'text' => 'Create User',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            ],
        ],
    ],
    'users.trashed' => [
        'key' => 'users.trashed',
        'route:url' => 'https://localhost.sample/admin/user/trashed',
        'route:name' => 'users.trashed',
        'parent' => 'module:user',
        'text' => 'Trashed User',
        'order' => 3,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
    ],
    'module:dashboard' => [
        'key' => 'module:dashboard',
        'route:url' => 'https://localhost.sample/admin/dashboard',
        'route:name' => 'dashboard',
        'text' => 'Dashboard',
        'order' => 1,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
    ],
];
