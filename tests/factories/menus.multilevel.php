<?php return array (
  'enabled' =>
  array (
    'module:setting' =>
    array (
      'name' => 'module:setting',
      'route:url' => '#',
      'order' => 900,
      'icon' => 'mdi mdi-tune',
      'text' => 'Settings',
      'description' => 'Manage settings',
      'routes' =>
      array (
        0 => 'settings.branding',
        1 => 'settings.preferences',
      ),
      'children' =>
      array (
        'settings:preferences' =>
        array (
          'name' => 'settings:preferences',
          'order' => 1,
          'icon' => 'mdi mdi-keyboard-settings-outline',
          'route:name' => 'settings.preferences',
          'permissions' =>
          array (
            0 => 'settings.preferences',
          ),
          'text' => 'Preferences',
          'description' => 'View the list of all settings',
        ),
        'settings:branding' =>
        array (
          'name' => 'settings:branding',
          'order' => 1,
          'icon' => 'mdi mdi-leaf',
          'route:name' => 'settings.branding',
          'permissions' =>
          array (
            0 => 'settings.branding',
          ),
          'text' => 'Branding',
          'description' => 'View the list of all settings',
          'children' =>
          array (
            'branding:general' =>
            array (
              'name' => 'branding:general',
              'order' => 1,
              'icon' => 'mdi mdi-leaf',
              'route:name' => 'settings.branding',
              'permissions' =>
              array (
                0 => 'settings.branding',
              ),
              'text' => 'General',
              'description' => 'Manage site branding options',
            ),
          ),
        ),
      ),
    ),
    'dashboard' =>
    array (
      'name' => 'dashboard',
      'order' => 5,
      'route:name' => 'dashboard',
      'icon' => 'mdi mdi-view-dashboard-outline',
      'always:viewable' => true,
      'text' => 'Dashboard',
      'description' => 'View app overview and summary.',
    ),
    'header:content' =>
    array (
      'name' => 'header:content',
      'is:header' => true,
      'always:viewable' => true,
      'order' => 20,
      'class' => 'separator',
      'markup' => 'span',
      'text' => 'Content',
    ),
    'module:user' =>
    array (
      'name' => 'module:user',
      'route:url' => '#',
      'route:name' => 'users.index',
      'routes' =>
      array (
        0 => 'users.index',
        1 => 'users.create',
        2 => 'users.edit',
        3 => 'users.show',
        4 => 'users.trashed',
        5 => 'roles.index',
        6 => 'roles.create',
        7 => 'roles.edit',
        8 => 'roles.show',
        9 => 'roles.trashed',
        10 => 'permissions.index',
        11 => 'permissions.create',
        12 => 'permissions.edit',
        13 => 'permissions.show',
        14 => 'permissions.trashed',
      ),
      'order' => 50,
      'icon' => 'mdi mdi-account-outline',
      'text' => 'Users',
      'description' => 'Manage users',
      'children' =>
      array (
        'index-users' =>
        array (
          'name' => 'index-users',
          'order' => 1,
          'route:name' => 'users.index',
          'routes' =>
          array (
            0 => 'users.create',
            1 => 'users.edit',
            2 => 'users.show',
          ),
          'permissions' =>
          array (
            0 => 'users.index',
          ),
          'text' => 'All Users',
          'description' => 'View the list of all users',
        ),
        'create-user' =>
        array (
          'name' => 'create-user',
          'order' => 2,
          'route:name' => 'users.create',
          'permissions' =>
          array (
            0 => 'users.create',
            1 => 'users.store',
          ),
          'text' => 'Add User',
          'description' => 'Create new user',
        ),
        'trashed-user' =>
        array (
          'name' => 'trashed-user',
          'order' => 3,
          'route:name' => 'users.trashed',
          'permissions' =>
          array (
            0 => 'users.trashed',
          ),
          'text' => 'Deactivated Users',
          'description' => 'View list of all users moved to trash',
        ),
        'module:role' =>
        array (
          'name' => 'module:role',
          'order' => 4,
          'route:name' => 'roles.index',
          'icon' => 'mdi mdi-shield-account-outline',
          'permissions' =>
          array (
            0 => 'roles.index',
          ),
          'text' => 'Roles',
          'description' => 'View the list of all roles',
          'routes' =>
          array (
            0 => 'roles.create',
            1 => 'roles.edit',
            2 => 'roles.show',
            3 => 'roles.trashed',
          ),
        ),
        'module:permission' =>
        array (
          'name' => 'module:permission',
          'order' => 100,
          'route:name' => 'permissions.index',
          'icon' => 'mdi mdi-shield-key-outline',
          'permissions' =>
          array (
            0 => 'permissions.index',
          ),
          'text' => 'Permissions',
          'description' => 'View the list of all permissions',
          'routes' =>
          array (
            0 => 'permissions.index',
            1 => 'permissions.create',
            2 => 'permissions.edit',
            3 => 'permissions.show',
            4 => 'permissions.trashed',
          ),
        ),
      ),
    ),
  ),
  'disabled' =>
  array (
  ),
);
