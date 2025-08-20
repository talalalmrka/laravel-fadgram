<?php

return [
    'default' => [
        'collection' => 'thumbnail',
        'fallback_path' => public_path('assets/images/post-thumbnail.svg'),
        'mime_types' => [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif',
            'image/svg',
        ],
        'single' => true,
        'format' => 'webp',
        'quality' => 100,
        'queued' => false,
        'responsive' => false,
        'conversion' => 'sm',
        'conversions' => [
            'sm' => [
                'width' => 400,
                'height' => 255,
            ],
            'md' => [
                'width' => 600,
                'height' => 337.5,
            ],
            'lg' => [
                'width' => 800,
                'height' => 450,
            ],
        ],
    ],


    //add settings for each model using table name ex:

    //users
    'users' => [
        'collection' => 'avatar',
        'fallback_path' => public_path('assets/images/profile.svg'),
        'conversions' => [
            'sm' => [
                'width' => 250,
                'height' => 250,
            ],
            'md' => [
                'width' => 400,
                'height' => 400,
            ],
            'lg' => [
                'width' => 600,
                'height' => 600,
            ],
        ],
    ],

    //posts
    'posts' => [
        'fallback_path' => public_path('assets/img/post-thumbnail.png'),
    ],

    //categories
    'categories' => [
        'fallback_path' => public_path('assets/img/category.png'),
    ],



];
