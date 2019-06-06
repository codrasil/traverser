<?php

return [
    'module:blog' => [
        'name' => 'module:blog',
        'route:url' => 'https://localhost.sample/admin/blog',
        'route:name' => 'blogs',
        'text' => 'Blogs',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'order' => 101,
    ],
    'module:tree' => [
        'name' => 'module:tree',
        'route:url' => 'https://localhost.sample/admin/tree',
        'route:name' => 'trees',
        'text' => 'Tree',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'order' => 101,
    ],
    'module:user' => [
        'name' => 'module:user',
        'route:url' => 'https://localhost.sample/admin/user',
        'route:name' => 'users',
        'text' => 'Users',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'order' => 100,
        'children' => [
            'users.index' => [
                'name' => 'users.index',
                'route:url' => 'https://localhost.sample/admin/user',
                'route:name' => 'users.index',
                'text' => 'All User',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'children' => [
                    'users.roles' => [
                        'name' => 'users.roles',
                        'route:url' => 'https://localhost.sample/admin/user',
                        'route:name' => 'users.roles',
                        'text' => 'All User Roles',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                    ],
                ],
            ],
            'users.create' => [
                'name' => 'users.create',
                'route:url' => 'https://localhost.sample/admin/user/create',
                'route:name' => 'users.create',
                'text' => 'Create User',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            ],
        ],
    ],
    'users.trashed' => [
        'name' => 'users.trashed',
        'route:url' => 'https://localhost.sample/admin/user/trashed',
        'route:name' => 'users.trashed',
        'parent' => 'module:user',
        'text' => 'Trashed User',
        'order' => 100,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
    ],
    'module:dashboard' => [
        'name' => 'module:dashboard',
        'route:url' => 'https://localhost.sample/admin/dashboard',
        'route:name' => 'dashboard',
        'text' => 'Dashboard',
        'order' => 1,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
    ],
];
