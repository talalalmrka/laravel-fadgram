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
    public static function registeredBlocks(): Collection
    {
        $blocks = [
            [
                'type' => 'container',
                'icon' => 'bi-window',
                'label' => __('Container'),
                'inner' => 'all',
                'features' => [
                    'typography',
                    'bgColor',
                    'bgImage',
                    'margin',
                    'padding',
                    'border',
                    'shadow',
                    'htmlAnchor',
                    'className',
                    'style',
                ],
                'children' => [],
                'attributes' => [
                    'type' => [
                        'type' => 'string',
                        'default' => 'container',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                ],
            ],
            [
                'type' => 'paragraph',
                'icon' => 'bi-paragraph',
                'label' => __('Paragraph'),
                'features' => [
                    'typography',
                    'bgColor',
                    'margin',
                    'padding',
                    'htmlAnchor',
                    'className',
                    'style',
                ],
                'attributes' => [
                    'content' => [
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
                'features' => [
                    'typography',
                    'bgColor',
                    'margin',
                    'padding',
                    'border',
                    'shadow',
                    'htmlAnchor',
                    'className',
                    'style',
                ],
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
                ],
            ],
            [
                'type' => 'button',
                'icon' => 'bi-square',
                'label' => __('Button'),
                'inner' => 'all',
                'features' => [
                    'margin',
                    'padding',
                    'border',
                    'htmlAnchor',
                    'className',
                    'style',
                ],
                'attributes' => [
                    'color' => [
                        'type' => 'string',
                        'default' => 'btn-primary',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'size' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'url' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'target' => [
                        'type' => 'string',
                        'default' => '',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                ],
            ],
            [
                'type' => 'hero',
                'icon' => 'bi-journal-bookmark-fill',
                'label' => __('Hero'),
                'inner' => ['button'],
                'features' => [
                    'typography',
                    'bgColor',
                    'bgImage',
                    'margin',
                    'padding',
                    'border',
                    'shadow',
                    'htmlAnchor',
                    'className',
                    'style',
                ],
                'children' => [
                    [
                        'type' => 'button',
                        'attributes' => [
                            'color' => 'btn-outline-light',
                            'size' => 'btn-lg',
                            'url' => '',
                            'target' => '',
                        ],
                    ],
                ],
                'attributes' => [
                    'theme' => [
                        'type' => 'string',
                        'default' => 'dark',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'fullscreen' => [
                        'type' => 'boolean',
                        'default' => false,
                        'rules' => ['boolean'],
                    ],
                    'title' => [
                        'type' => 'string',
                        'default' => 'Hero title',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'subtitle' => [
                        'type' => 'string',
                        'default' => 'Hero subtitle',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                    'text' => [
                        'type' => 'string',
                        'default' => 'Hero text',
                        'rules' => ['nullable', 'string', 'max:255'],
                    ],
                ],
            ]
            /*[
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
            ],
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
        return collect(self::resolveRegisteredBlocks($blocks));
    }
    public static function featureAtts($feature)
    {
        $atts = [
            'typography' => [
                'textColor' => [
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
            ],
            'bgColor' => [
                'bgColor' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'bgImage' => [
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
            ],
            'margin' => [
                'margin' => [
                    'type' => 'array',
                    'default' => self::spacingAttributes(),
                    'rules' => ['nullable', 'array'],
                ],
            ],
            'padding' => [
                'padding' => [
                    'type' => 'array',
                    'default' => self::spacingAttributes(),
                    'rules' => ['nullable', 'array'],
                ],
            ],
            'border' => [
                'borderSize' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
                'borderColor' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
                'borderStyle' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
                'borderRadius' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'shadow' => [
                'shadowSize' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
                'shadowColor' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'htmlAnchor' => [
                'htmlAnchor' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'className' => [
                'className' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'style' => [
                'style' => [
                    'type' => 'string',
                    'default' => '',
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],

        ];
        return data_get($atts, $feature);
    }
    public static function resolveBlockAttributes($block)
    {
        $features = data_get($block, 'features', []);
        $atts = data_get($block, 'attributes', []);
        foreach ($features as $feature) {
            $featureAtts = self::featureAtts($feature);
            foreach ($featureAtts as $k => $v);
            $atts[$k] = $v;
        }
        return $atts;
    }
    public static function spacingAttributes()
    {
        $atts = [];
        foreach (['sm', 'md', 'lg', 'xl'] as $breakpoint) {
            $atts[$breakpoint] = [
                'top' => '',
                'start' => '',
                'end' => '',
                'bottom' => '',
            ];
        }
        return $atts;
    }
    public static function resolveRegisteredBlocks(array $blocks)
    {
        return arr_map($blocks, function ($block) {
            $block = array_merge($block, [
                'id' => uniqid('block-'),
            ]);
            $block['attributes'] = self::resolveBlockAttributes($block);
            $children = data_get($block, 'children');
            if ($children && is_array($children) && !empty($children)) {
                $block['children'] = static::resolveRegisteredBlocks($children);
            }
            return $block;
        });
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
