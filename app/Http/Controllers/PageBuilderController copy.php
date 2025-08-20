<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlocksRequest;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PageBuilderController extends Controller
{
    public static function registeredBlockss(): Collection
    {
        $blocks = [
            [
                'type' => 'posts_grid',
                'icon' => 'bi-newspaper',
                'label' => __('Posts grid'),
                'defaults' => [
                    'title' => '',
                    'show_title' => true,
                    'categories' => [],
                    'tags' => [],
                    'user' => null,
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => '',
                ],
                'rules' => [
                    'title' => ['nullable', 'string', 'max:255'],
                    'show_title' => ['nullable', 'boolean'],
                    'categories' => ['nullable', 'array'],
                    'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
                    'tags' => ['nullable', 'array'],
                    'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
                    'users' => ['nullable', 'array'],
                    'users.*' => ['integer', Rule::exists('users', 'id')],
                    'limit' => ['nullable', 'numeric', 'max:100'],
                    'sort' => ['nullable', 'string', Rule::in(sort_values())],
                    'className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'quotes_grid',
                'icon' => 'bi-quote',
                'label' => __('Quotes grid'),
                'defaults' => [
                    'title' => '',
                    'show_title' => true,
                    'categories' => [],
                    'tags' => [],
                    'users' => [],
                    'authors' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => '',
                ],
                'rules' => [
                    'title' => ['nullable', 'string', 'max:255'],
                    'show_title' => ['nullable', 'boolean'],
                    'categories' => ['nullable', 'array'],
                    'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
                    'tags' => ['nullable', 'array'],
                    'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
                    'users' => ['nullable', 'array'],
                    'users.*' => ['integer', Rule::exists('users', 'id')],
                    'authors' => ['nullable', 'array'],
                    'authors.*' => ['nullable', 'integer', Rule::exists('authors', 'id')->where('status', 'publish')],
                    'limit' => ['nullable', 'numeric', 'max:100'],
                    'sort' => ['nullable', 'string', Rule::in(sort_values())],
                    'className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'quotes_gallery',
                'icon' => 'bi-image',
                'label' => __('Quotes gallery'),
                'defaults' => [
                    'title' => '',
                    'show_title' => true,
                    'categories' => [],
                    'tags' => [],
                    'users' => [],
                    'authors' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => '',
                ],
                'rules' => [
                    'title' => ['nullable', 'string', 'max:255'],
                    'show_title' => ['nullable', 'boolean'],
                    'categories' => ['nullable', 'array'],
                    'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
                    'tags' => ['nullable', 'array'],
                    'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
                    'users' => ['nullable', 'array'],
                    'users.*' => ['integer', Rule::exists('users', 'id')],
                    'authors' => ['nullable', 'array'],
                    'authors.*' => ['nullable', 'integer', Rule::exists('authors', 'id')->where('status', 'publish')],
                    'limit' => ['nullable', 'numeric', 'max:100'],
                    'sort' => ['nullable', 'string', Rule::in(sort_values())],
                    'className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'books_grid',
                'icon' => 'bi-book',
                'label' => __('Books grid'),
                'defaults' => [
                    'title' => '',
                    'show_title' => true,
                    'categories' => [],
                    'tags' => [],
                    'users' => [],
                    'authors' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => '',
                ],
                'rules' => [
                    'title' => ['nullable', 'string', 'max:255'],
                    'show_title' => ['nullable', 'boolean'],
                    'categories' => ['nullable', 'array'],
                    'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
                    'tags' => ['nullable', 'array'],
                    'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
                    'users' => ['nullable', 'array'],
                    'users.*' => ['integer', Rule::exists('users', 'id')],
                    'authors' => ['nullable', 'array'],
                    'authors.*' => ['nullable', 'integer', Rule::exists('authors', 'id')->where('status', 'publish')],
                    'limit' => ['nullable', 'numeric', 'max:100'],
                    'sort' => ['nullable', 'string', Rule::in(sort_values())],
                    'className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'categories_grid',
                'icon' => 'bi-folder',
                'label' => __('Categories grid'),
                'defaults' => [
                    'title' => '',
                    'show_title' => true,
                    'users' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => '',
                ],
                'rules' => [
                    'title' => ['nullable', 'string', 'max:255'],
                    'show_title' => ['nullable', 'boolean'],
                    'users' => ['nullable', 'array'],
                    'users.*' => ['integer', Rule::exists('users', 'id')],
                    'limit' => ['nullable', 'numeric', 'max:100'],
                    'sort' => ['nullable', 'string', Rule::in(sort_values())],
                    'className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'authors_grid',
                'icon' => 'bi-person',
                'label' => __('Authors grid'),
                'defaults' => [
                    'title' => '',
                    'show_title' => true,
                    'users' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => '',
                ],
                'rules' => [
                    'title' => ['nullable', 'string', 'max:255'],
                    'show_title' => ['nullable', 'boolean'],
                    'users' => ['nullable', 'array'],
                    'users.*' => ['integer', Rule::exists('users', 'id')],
                    'limit' => ['nullable', 'numeric', 'max:100'],
                    'sort' => ['nullable', 'string', Rule::in(sort_values())],
                    'className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'text',
                'icon' => 'bi-pencil-square',
                'label' => __('Text'),
                'defaults' => [
                    'content' => '',
                ],
                'rules' => [
                    'content' => ['nullable', 'string', 'max:5000'],
                ]
            ],
            [
                'type' => 'button',
                'icon' => 'bi-square',
                'label' => __('Button'),
                'defaults' => [
                    'label' => 'Button',
                    'icon' => '',
                    'url' => '',
                    'target' => '',
                    'textColor' => 'primary',
                    'outline' => false,
                    'gradient' => false,
                    'pill' => false,
                    'size' => null,
                    'className' => '',
                ],
                'rules' => [
                    'label' => ['nullable', 'string', 'max:255'],
                    'icon' => ['nullable', 'string', 'max:255'],
                    'url' => ['nullable', 'string', 'max:255'],
                    'target' => ['nullable', 'string', 'max:255'],
                    'textColor' => ['nullable', 'string', 'max:255'],
                    'outline' => ['boolean'],
                    'gradient' => ['boolean'],
                    'pill' => ['boolean'],
                    'size' => ['nullable', 'string', 'max:255'],
                    'className' => ['nullable', 'string', 'max:255'],
                ]
            ],
            [
                'type' => 'hero',
                'icon' => 'bi-journal-bookmark-fill',
                'label' => __('Hero'),
                'defaults' => [
                    'theme' => 'dark',
                    'fullscreen' => false,
                    'title' => 'Hero Title',
                    'subtitle' => 'Hero subtitle',
                    'text' => '',
                    'textColor' => 'white',
                    'bgColor' => 'primary',
                    'image' => '',
                    'className' => '',
                    'children' => [
                        [
                            'type' => 'button',
                            'icon' => 'bi-globe',
                            'label' => 'Action 1',
                            'url' => '',
                            'textColor' => 'primary',
                            'outline' => false,
                            'gradient' => false,
                            'pill' => true,
                            'size' => 'lg',
                            'className' => '',
                        ],
                        [
                            'type' => 'button',
                            'icon' => 'bi-grid',
                            'label' => 'Action 2',
                            'url' => '',
                            'textColor' => 'white',
                            'outline' => true,
                            'gradient' => false,
                            'pill' => true,
                            'size' => 'lg',
                            'className' => '',
                        ],
                    ],
                ],
                'rules' => [
                    'theme' => ['nullable', 'string'],
                    'fullscreen' => ['boolean'],
                    'title' => ['nullable', 'string', 'max:255'],
                    'subtitle' => ['nullable', 'string', 'max:255'],
                    'text' => ['nullable', 'string', 'max:255'],
                    'textColor' => ['nullable', 'string', 'max:255'],
                    'bgColor' => ['nullable', 'string', 'max:255'],
                    'image' => ['nullable', 'url', 'max:255'],
                    'className' => ['nullable', 'string', 'max:255'],
                    'children' => ['nullable', 'array'],
                    'children.*' => ['nullable', 'array'],
                    'children.*.type' => ['required', 'string'],
                    'children.*.label' => ['nullable', 'string', 'max:255'],
                    'children.*.url' => ['nullable', 'string', 'max:255'],
                    'children.*.color' => ['nullable', 'string', 'max:255'],
                    'children.*.outline' => ['boolean'],
                    'children.*.gradient' => ['boolean'],
                    'children.*.pill' => ['boolean'],
                    'children.*.size' => ['nullable', 'string', 'max:255'],
                    'children.*.className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'slide',
                'icon' => 'bi-window',
                'label' => __('Slide'),
                'defaults' => [
                    'type' => 'slide',
                    'title' => 'Slide 1 title',
                    'subtitle' => 'Slide 1 subtitle',
                    'image' => '',
                    'className' => '',
                    'actionLabel' => 'Action',
                    'actionIcon' => 'bi-arrow-up-right',
                    'actionIconPosition' => 'start',
                    'actionUrl' => '',
                    'actionTarget' => '_blank',
                    'actionClassName' => '',
                ],
            ],
            [
                'type' => 'carousel',
                'icon' => 'bi-collection',
                'label' => __('Carousel'),
                'defaults' => [
                    'autoplay' => true,
                    'controls' => true,
                    'indicators' => true,
                    'transition' => 'slide',
                    'duration' => 700,
                    'interval' => 3500,
                    'className' => '',
                    'children' => [
                        [
                            'type' => 'slide',
                            'title' => 'Slide 1 title',
                            'subtitle' => 'Slide 1 subtitle',
                            'image' => '',
                            'className' => '',
                            'actionLabel' => 'Action',
                            'actionIcon' => 'bi-arrow-up-right',
                            'actionIconPosition' => 'start',
                            'actionUrl' => '',
                            'actionTarget' => '_blank',
                            'actionClassName' => '',
                        ],
                        [
                            'type' => 'slide',
                            'title' => 'Slide 2 title',
                            'subtitle' => 'Slide 2 subtitle',
                            'image' => '',
                            'className' => '',
                            'actionLabel' => 'Action',
                            'actionIcon' => 'bi-arrow-up-right',
                            'actionIconPosition' => 'start',
                            'actionUrl' => '',
                            'actionTarget' => '_blank',
                            'actionClassName' => '',
                        ],
                        [
                            'type' => 'slide',
                            'title' => 'Slide 3 title',
                            'subtitle' => 'Slide 3 subtitle',
                            'image' => '',
                            'className' => '',
                            'actionLabel' => 'Action',
                            'actionIcon' => 'bi-arrow-up-right',
                            'actionIconPosition' => 'start',
                            'actionUrl' => '',
                            'actionTarget' => '_blank',
                            'actionClassName' => '',

                        ],
                    ],
                ],
                'rules' => [
                    'autoplay' => ['boolean'],
                    'controls' => ['boolean'],
                    'indicators' => ['boolean'],
                    'transition' => ['required', 'string', 'max:255'],
                    'duration' => ['nullable', 'numeric'],
                    'interval' => ['nullable', 'numeric'],
                    'className' => ['nullable', 'string', 'max:255'],
                    'children' => ['nullable', 'array'],
                    'children.*' => ['nullable', 'array'],
                    'children.*' => ['nullable', 'array'],
                    'children.*.type' => ['required', 'string'],
                    'children.*.title' => ['nullable', 'string', 'max:255'],
                    'children.*.subtitle' => ['nullable', 'string', 'max:255'],
                    'children.*.image' => ['nullable', 'string', 'max:255'],
                    'children.*.actionLabel' => ['nullable', 'string', 'max:255'],
                    'children.*.actionIcon' => ['nullable', 'string', 'max:255'],
                    'children.*.actionIconPosition' => ['nullable', 'string', 'max:255'],
                    'children.*.actionUrl' => ['nullable', 'string', 'max:255'],
                    'children.*.actionTarget' => ['nullable', 'string', 'max:255'],
                    'children.*.actionClassName' => ['nullable', 'string', 'max:255'],
                    'children.*.className' => ['nullable', 'string', 'max:255'],
                ],
            ],
            [
                'type' => 'container',
                'icon' => 'bi-window',
                'label' => __('Container'),
                'defaults' => [
                    'fluid' => false,
                    'className' => '',
                    'children' => [],
                ],
                'rules' => [
                    'fluid' => ['boolean'],
                    'className' => ['nullable', 'string', 'max:255'],
                    'children' => ['nullable', 'array'],
                    'children.*' => ['nullable', 'array'],
                ],
            ],
        ];
        $map = Post::resolveBlocks($blocks);
        return collect($map);
    }

    public static function registeredBlocks(): Collection
    {
        $blocks = [
            [
                'type' => 'container',
                'icon' => 'bi-window',
                'label' => __('Container'),
                'inner' => 'all',
                'children' => [],
                'attributes' => [
                    'fullWidth' => [
                        'type' => 'boolean',
                        'default' => false,
                        'rules' => ['boolean'],
                    ],
                    'textColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgImage' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgSize' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgPosition' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgAttachment' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontSize' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontWeight' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontStyle' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textTransform' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textAlign' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'className' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'style' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                ],
            ],
            [
                'type' => 'paragraph',
                'icon' => 'bi-paragraph',
                'label' => __('Paragraph'),
                'attributes' => [
                    'content' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgImage' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgSize' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgPosition' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgAttachment' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontSize' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontWeight' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontStyle' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textTransform' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textAlign' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'className' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'style' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                ],
            ],
            [
                'type' => 'heading',
                'icon' => 'bi-bookmark-fill',
                'label' => __('Heading'),
                'attributes' => [
                    'tag' => [
                        'type' => 'string',
                        'default' => 'h1',
                        'rules' => ['required', 'string', Rule::in(collect(range(1, 6))->map(fn($l) => "h$l")->toArray())],
                    ],
                    'title' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'icon' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontSize' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontWeight' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontStyle' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textTransform' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textAlign' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'className' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'style' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                ],
            ],/*
            [
                'type' => 'posts_grid',
                'icon' => 'bi-newspaper',
                'label' => __('Posts grid'),
                'attributes' => [
                    'title' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'show_title' => [
                        'type' => 'boolean',
                        'default' => true,
                    ],
                    'categories' => [
                        'type' => 'array',
                        'default' => [],
                        'rules' => [
                            'categories' => ['nullable', 'array'],
                            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
                        ],
                    ],
                    'tags' => [
                        'type' => 'array',
                        'default' => [],
                        'rules' => [
                            'tags' => ['nullable', 'array'],
                            'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
                        ],
                    ],
                    'users' => [
                        'type' => 'array',
                        'default' => [],
                        'rules' => [
                            'users' => ['nullable', 'array'],
                            'users.*' => ['nullable', 'integer', Rule::exists('users', 'id')],
                        ],
                    ],
                    'limit' => [
                        'type' => 'integer',
                        'default' => 5,
                        'rules' => ['nullable', 'numeric'],
                    ],
                    'sort' => [
                        'type' => 'string',
                        'default' => 'newest',
                        'rules' => ['nullable', 'string', Rule::in(sort_values())],
                    ],
                    'textColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'bgColor' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontSize' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontWeight' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fontStyle' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textTransform' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'textAlign' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'className' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'style' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                ],
            ],*/
        ];
        return collect(arr_map($blocks, fn($block) => array_merge([
            'id' => uniqid('block-'),
        ], $block)));
    }
    public static function registeredBlock($type): array | null
    {
        return self::registeredBlocks()->firstWhere('type', $type);
    }
    public static function blockTypes()
    {
        return self::registeredBlocks()->map(fn($block) => data_get($block, 'type'))->toArray();
    }
    public static function blockRuless($type)
    {
        $blocks = self::registeredBlocks();
        $block = collect($blocks)->firstWhere('type', $type);
        return $block ? ($block['rules'] ?? []) : [];
    }
    public static function blockRules($type): array
    {
        $block = self::registeredBlock($type);
        if ($block) {
            $rules = [];
            $attributes = data_get($block, 'attributes', []);
            foreach ($attributes as $k => $v) {
                $rules[$k] = data_get($v, 'rules', []);
            }
            return $rules;
        } else {
            return [];
        }
    }

    public static function blockDefaults($type): array
    {
        $block = self::registeredBlock($type);
        $defaults = [];
        if ($block) {
            $attributes = data_get($block, 'attributes', []);
            foreach ($attributes as $k => $v) {
                $defaults[$k] = data_get($v, 'default');
            }
        }
        return $defaults;
    }
    public static function blockDefaultss($type)
    {
        $blocks = self::registeredBlocks();
        $block = collect($blocks)->firstWhere('type', $type);
        return $block ? ($block['defaults'] ?? []) : [];
    }
    public function index(Request $request, Post $page): Response
    {
        $page->updateMeta('builder_enabled', true);
        return Inertia::render('builder/Index', [
            'page' => $page->toArray(),
            'pages' => Post::type('page')->publish()->get()->toArray(),
            'categories' => fn() => Category::type('category')->with('children')->get()->toArray(),
            'tags' => fn() => Category::type('tag')->get()->toArray(),
            'authors' => fn() => Author::publish()->get()->toArray(),
            'users' => fn() => User::all()->toArray(),
            'sortOptions' => fn() => sort_options(),
            'registeredBlocks' => fn() => self::registeredBlocks()->toArray(),
        ])
            ->rootView('layouts.inertia')
            ->withViewData([
                'title' => __('Edit page ":name"', ['name' => $page->name]),
                'containerClass' => 'page-builder-container',
                'showTitle' => false,
            ]);
    }

    public function store(StoreBlocksRequest $request, Post $page)
    {
        $blocks = data_get($request->validated(), 'blocks', []);
        // dd($blocks);
        $save = $page->saveBlocks($blocks);
        if ($save) {
            $label = __('Show the page');
            //return back()->with('save', __('Saved successfully :link', ['link' => a(['href' => $page->permalink, 'title' => $page->name, 'target' => 'blank', 'label' => $label])]));
            return back()->with('save', __('Saved successfully.'));
        } else {
            return back()->withErrors(['save', __('Save failed!')]);
        }
    }

    public function renderBlock(Request $request)
    {
        return block($request->all())->render();
    }
    public function blockPreview(Request $request)
    {
        return view('components.block-preview', [
            'block' => $request->all(),
        ]);
    }
    public function resolveConversions(Media $media)
    {
        $conversions = [
            'full' => $media->getUrl(),
        ];
        $generated = $media->generated_conversions ?? [];

        if (is_iterable($generated)) {
            foreach ($generated as $name => $available) {
                if ($available) {
                    // getUrl(name) -> conversion url, getUrl() -> original
                    $conversions[$name] = $media->getUrl($name);
                }
            }
        }
        return $conversions;
    }

    public function resolveImage(Media $media): array
    {
        return array_merge($media->toArray(), [
            'conversions' => $this->resolveConversions($media),
        ]);
    }
    public function pageImages(Post $page)
    {
        return response()->json(
            $page->getMedia('images')->map(fn(Media $media) => $this->resolveImage($media))->toArray()
        );
    }
    public function uploadImage(Request $request, Post $page)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,webp,gif,svg|max:5120',
        ]);

        $image = $request->file('image');

        // Add image to the "images" media collection
        $media = $page->addMedia($image)
            ->toMediaCollection('images');

        return response()->json($this->resolveImage($media));
    }

    public function classic(Post $page)
    {
        $page->updateMeta('builder_enabled', false);
        return redirect($page->edit_url);
    }
}
