<?php

return [
    'name'           => [
        'name' => 'Name',
    ],
    'slug'           => [
        'name' => 'Slug',
    ],
    'description'    => [
        'name' => 'Description',
    ],
    'allowed_roles'  => [
        'name' => 'Allowed Roles',
    ],
    'virtualize'     => [
        'name'         => 'Virtualize',
        'label'        => 'Enable Virtualization',
        'instructions' => 'This will add the namespace to the sidebar, create user permissions per stream, and otherwise make this namespace act like a virtual module.',
    ],
    'icon'           => [
        'name'         => 'Navigation Icon',
        'instructions' => 'Specify the icon to display in the navigation.',
    ],
    'index_route'    => [
        'name'         => 'Index Route',
        'instructions' => 'Specify the optional route pattern for listing entries in this stream.',
    ],
    'index_template' => [
        'name'         => 'Index Template',
        'instructions' => 'Specify the template for listing entries in this stream.',
    ],
    'view_route'     => [
        'name'         => 'View Route',
        'instructions' => 'Specify the optional route pattern for viewing an entry in this stream.',
    ],
    'view_template'  => [
        'name'         => 'View Template',
        'instructions' => 'Specify the template for viewing an entry in this stream.',
    ],
];
