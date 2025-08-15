<?php

return [
    'name' => 'Midtrans',
    'alias' => 'midtrans',
    'logo' => 'Modules/Midtrans/Resources/assets/logo.png',
    'gateway' => 'Midtrans',
    'description' => 'Pay with Midtrans',

    // Midtrans specific settings
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    'lifecycle' => true, // To show in admin panel
    'fields' => [
        'server_key' => [
            'label' => 'Server Key',
            'type' => 'text',
            'required' => true,
        ],
        'client_key' => [
            'label' => 'Client Key',
            'type' => 'text',
            'required' => true,
        ],
        'is_production' => [
            'label' => 'Environment',
            'type' => 'select',
            'options' => [
                'true' => 'Production',
                'false' => 'Sandbox',
            ],
            'required' => true,
        ],
         'status' => [
            'label' => 'Status',
            'type' => 'select',
            'options' => [
                '1' => 'Active',
                '0' => 'Inactive',
            ],
            'required' => true,
        ],
    ],
];