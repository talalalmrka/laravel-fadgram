<?php
return [
    'positions' => [
        'header',
        'footer',
        'social',
        'marwan',
    ],
    'default' => [
        [
            'name' => 'Header menu',
            'position' => 'header',
            'class_name' => 'header-menu',
            'items' => [
                [
                    'name' => 'Home',
                    'icon' => 'bi-house-fill',
                    'type' => 'custom',
                    'url' => 'http://localhost:8000',
                ],
            ],
        ],
    ],
];
