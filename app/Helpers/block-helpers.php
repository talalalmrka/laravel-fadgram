<?php

use App\Http\Controllers\PageBuilderController;
use Illuminate\Support\Collection;

if (!function_exists('registered_blocks')) {
    function registered_blocks(): Collection
    {
        return PageBuilderController::registeredBlocks();
    }
}
if (!function_exists('registered_block')) {
    function registered_block(string $type): array|null
    {
        $block = registered_blocks()->firstWhere('type', $type) ?? [];
        return $block ?? null;
    }
}
if (!function_exists('registered_blocks')) {
    function registered_blocks(): Collection
    {
        return PageBuilderController::registeredBlocks();
    }
}
if (!function_exists('block_features')) {
    function block_features($type): Collection
    {
        return PageBuilderController::blockFeatures($type);
    }
}
if (!function_exists('registered_features')) {
    function registered_features(): Collection
    {
        return PageBuilderController::registeredFeatures();
    }
}
if (!function_exists('block_defaults')) {
    function block_defaults($type): array
    {
        return PageBuilderController::blockDefaults($type);
    }
}

if (!function_exists('features')) {
    function features()
    {
        return PageBuilderController::features();
    }
}

if (!function_exists('flat')) {
    function flat($obj)
    {
        $ret = [];

        if (is_array($obj)) {
            foreach ($obj as $val) {
                $ret = array_merge($ret, flat($val));
            }
        } elseif (is_object($obj)) {
            foreach (get_object_vars($obj) as $val) {
                $ret = array_merge($ret, flat($val));
            }
        } else {
            $ret[] = $obj;
        }

        // Filter out null, empty string, or falsey values
        return array_filter($ret, function ($n) {
            return $n !== null && $n !== '' && $n !== false;
        });
    }
}
if (!function_exists('block_classes')) {
    function block_classes($block, array $merge = [])
    {
        $exclude = ['bgImage', 'htmlAnchor', 'style'];
        $atts = block_atts($block);
        $features = registered_features();
        $allClasses = [];
        $features->each(function ($feature) use (&$allClasses, $atts, $exclude) {
            if (!in_array($feature, $exclude)) {
                $attr = $atts->get($feature);
                if ($attr) {
                    $allClasses[$feature] = $attr;
                }
            }
        });
        $classes = array_unique(flat([
            ...$allClasses,
            ...$merge,
        ]));
        return css_classes($classes);
    }
}
if (!function_exists('block_styles')) {
    function block_styles($block, $merge = [])
    {
        $atts = data_get($block, 'attributes', []);
        $bgImage = data_get($atts, 'bgImage');
        $style = data_get($atts, 'style');
        $styles = [
            ...($bgImage ? ["background-image: url($bgImage)"] : []),
            ...$merge,
            $style,
        ];
        return css_styles(array_filter($styles, fn($s) => !empty($s)));
    }
}

if (!function_exists('block_atts')) {
    function block_atts($block): Collection
    {
        $type = data_get($block, 'type');
        return collect(array_merge(block_defaults($type), data_get($block, 'attributes', [])));
    }
}
if (!function_exists('dm')) {
    function dm($data, $style = 'advanced')
    {
        return view('components.dump', ['data' => $data, 'style' => $style]);
    }
}
if (!function_exists('blocks')) {
    function blocks($blocks)
    {
        // return dm(dump_blocks($blocks), 'simple');
        return is_array($blocks) ? implode('', arr_map($blocks, fn($block) => block($block))) : '';
    }
}
if (!function_exists('dump_blocks')) {
    function dump_blocks($blocks)
    {
        return arr_map(is_array($blocks) ? $blocks : [], fn($block) => dump_block($block));
    }
}
if (!function_exists('dump_block')) {
    function dump_block($block)
    {
        $ret = [
            'type' => data_get($block, 'type'),
            'class' => block_classes($block),
            'style' => block_styles($block),
        ];
        $children = data_get($block, 'children');
        if (!empty($children)) {
            $ret['children'] = dump_blocks($children);
        }
        return $ret;
    }
}
if (!function_exists('block')) {
    function block($block)
    {
        $type = data_get($block, 'type');
        try {
            return match ($type) {
                'container' => block_container($block),
                'paragraph' => block_paragraph($block),
                'button' => block_button($block),
                'heading' => block_heading($block),
                'icon' => block_icon($block),
                'link' => block_link($block),
                'posts' => block_posts($block),
                'quotes' => block_quotes($block),
                'quote_day' => block_quote_day($block),
                'authors' => block_authors($block),
                'books' => block_books($block),
                'categories' => block_categories($block),
                'html' => block_html($block),
                'carousel' => block_carousel($block),
                'breadcrumb' => block_breadcrumb($block),
                default => dm($block),
            };
        } catch (Exception $e) {
            return container([
                'class' => 'alert alert-error sm soft',
                'content' => $e->getMessage(),
            ]);
        }
    }
}
if (!function_exists('block_container')) {
    function block_container($block)
    {
        $atts = block_atts($block);
        $children = data_get($block, 'children', []);
        return container([
            'class' => block_classes($block, [
                $atts->only(['type', 'cols', 'gap'])->toArray(),
            ]),
            'atts' => [
                'style' => block_styles($block),
            ],
            // 'content' => implode('', arr_map($children, fn($child) => block($child))),
            'content' => blocks($children),
        ]);
    }
}
if (!function_exists('block_paragraph')) {
    function block_paragraph($block)
    {
        $atts = block_atts($block);
        return container([
            'tag' => 'p',
            'class' => block_classes($block),
            'atts' => [
                'style' => css_styles($block),
            ],
            'content' => $atts->get('content', ''),
        ]);
    }
}
if (!function_exists('block_button')) {
    function block_button($block)
    {
        $atts = block_atts($block);
        return view('components.button', [
            'label' => $atts->get('label'),
            'icon' => $atts->get('icon'),
            'href' => $atts->get('url'),
            'color' => '',
            'class' => block_classes($block, [
                $atts->get('color'),
                $atts->get('size'),
            ]),
            'atts' => [
                'style' => block_styles($block),
            ],

        ]);
    }
}
if (!function_exists('block_icon')) {
    function block_icon($block)
    {
        $atts = block_atts($block);
        return view('components.icon', [
            'icon' => $atts->get('icon'),
            'class' => block_classes($block, [
                $atts->get('size'),
            ]),
            'atts' => [
                'style' => block_styles($block),
            ],
        ]);
    }
}
if (!function_exists('block_link')) {
    function block_link($block)
    {
        $atts = block_atts($block);
        return a([
            'label' => $atts->get('label'),
            'icon' => $atts->get('icon'),
            'href' => $atts->get('url'),
            'class' => block_classes($block, [
                $atts->get('type'),
            ]),
            'atts' => [
                'style' => block_styles($block),
            ],

        ]);
    }
}
if (!function_exists('block_heading')) {
    function block_heading($block)
    {
        $atts = block_atts($block);
        $title = $atts->get('title');
        $icon = $atts->get('icon');
        return container([
            'tag' => $atts->get('tag', 'h2'),
            'class' => block_classes($block, [
                // 'flex-space-2' => $title && $icon,
            ]),
            'atts' => [
                'style' => block_styles($block),
            ],
            'content' => $icon ? implode('', [
                container([
                    'tag' => 'i',
                    'class' => css_classes([
                        'icon',
                        $icon,
                    ]),
                ]),
                container([
                    'tag' => 'span',
                    'content' => $title,
                ]),
            ])
                : $title,
        ]);
    }
}
if (!function_exists('block_posts')) {
    function block_posts($block)
    {
        $atts = block_atts($block);
        $posts = get_posts($atts->toArray());
        $layout = $atts->get('layout', 'grid');
        $view = match ($layout) {
            'grid' => 'components.posts-grid',
            'carousel' => 'components.posts-carousel',
        };
        return view($view, [
            'title' => $atts->get('show_title', false) ? $atts->get('title') : null,
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'posts' => $posts,
        ]);
    }
}


if (!function_exists('block_quotes')) {
    function block_quotes($block)
    {
        $atts = block_atts($block);
        $layout = $atts->get('layout', 'grid');
        $view = match ($layout) {
            'grid' => 'components.quotes-grid',
            'carousel' => 'components.quotes-carousel',
        };
        $quotes = get_quotes($atts->toArray());
        return view($view, [
            'title' => $atts->get('show_title', false) ? $atts->get('title') : null,
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'quotes' => $quotes,
        ]);
    }
}


if (!function_exists('block_quotes_gallery')) {
    function block_quotes_gallery($block)
    {
        $atts = block_atts($block);
        $quotes = get_quotes($atts->toArray());
        return view('components.quotes-gallery', [
            'title' => $atts->get('show_title', false) ? $atts->get('title') : null,
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'posts' => $quotes,
        ]);
    }
}


if (!function_exists('block_books')) {
    function block_books($block)
    {
        $atts = block_atts($block);
        $layout = $atts->get('layout', 'grid');
        $view = match ($layout) {
            'grid' => 'components.books-grid',
            'carousel' => 'components.books-carousel',
        };
        $books = get_books($atts->toArray());
        return view($view, [
            'title' => $atts->get('show_title', false) ? $atts->get('title') : null,
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'books' => $books,
        ]);
    }
}


if (!function_exists('block_categories')) {
    function block_categories($block)
    {
        $atts = block_atts($block);
        $layout = $atts->get('layout', 'grid');
        $view = match ($layout) {
            'grid' => 'components.categories-grid',
            'carousel' => 'components.categories-carousel',
        };
        $categories = get_categories($atts->toArray());
        return view($view, [
            'title' => $atts->get('show_title', false) ? $atts->get('title') : null,
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'categories' => $categories,
        ]);
    }
}
if (!function_exists('block_authors')) {
    function block_authors($block)
    {
        $atts = block_atts($block);
        $layout = $atts->get('layout', 'grid');
        $view = match ($layout) {
            'grid' => 'components.authors-grid',
            'carousel' => 'components.authors-carousel',
        };
        $authors = get_authors($atts->toArray());
        return view($view, [
            'title' => $atts->get('show_title', false) ? $atts->get('title') : null,
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'authors' => $authors,
        ]);
    }
}
if (!function_exists('block_html')) {
    function block_html($block)
    {
        $atts = block_atts($block);
        return $atts->get('content', '');
    }
}

if (!function_exists('block_carousel')) {
    function block_carousel($block)
    {
        $atts = block_atts($block);
        return view('components.carousel', [
            'theme' => (bool) $atts->get('theme', 'dark'),
            'autoplay' => (bool) $atts->get('autoplay', true),
            'controls' => (bool) $atts->get('controls', true),
            'indicators' => (bool) $atts->get('indicators', true),
            'transition' => $atts->get('transition', 'slide'),
            'duration' => $atts->get('duration'),
            'interval' => $atts->get('interval'),
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'slides' => arr_map(data_get($block, 'children', []), fn($child) => data_get($child, 'attributes', [])),
        ]);
    }
}

if (!function_exists('block_quote_day')) {
    function block_quote_day($block)
    {
        $atts = block_atts($block);
        $quotes = get_quotes_for_day($atts->toArray());
        return view('components.quotes-for-day', [
            'title' => $atts->get('show_title', false) ? $atts->get('title') : null,
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
            'quotes' => $quotes,
        ]);
    }
}

if (!function_exists('block_breadcrumb')) {
    function block_breadcrumb($block)
    {
        return view('components.breadcrumbs', [
            'class' => block_classes($block),
            'atts' => [
                'style' => block_styles($block),
            ],
        ]);
    }
}
