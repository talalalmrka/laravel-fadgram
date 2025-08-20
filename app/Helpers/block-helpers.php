<?php

use App\Http\Controllers\PageBuilderController;
use Illuminate\Support\Collection;

if (!function_exists('registered_blocks')) {
    function registered_blocks(): Collection
    {
        return PageBuilderController::registeredBlocks();
    }
}

if (!function_exists('block_defaults')) {
    function block_defaults($type): array
    {
        return PageBuilderController::blockDefaults($type);
    }
}
if (!function_exists('spacing_classes')) {
    function spacing_classes($block)
    {
        $atts = data_get($block, 'attributes', []);
        $classes = [];
        $margin = $atts['margin'] ?? [];
        foreach ($margin as $b) {
            if (is_array($b)) {
                foreach ($b as $c) {
                    if (!empty($c)) {
                        $classes[] = $c;
                    }
                }
            }
        }
        $padding = $atts['padding'] ?? [];
        foreach ($padding as $d) {
            if (is_array($d)) {
                foreach ($d as $e) {
                    if (!empty($e)) {
                        $classes[] = $e;
                    }
                }
            }
        }
        return $classes;
    }
}
if (!function_exists('block_classes')) {
    function block_classes($block, $merge = [])
    {
        $attributes = data_get($block, 'attributes', []);
        $names = [
            'textColor',
            'bgColor',
            'bgSize',
            'bgPosition',
            'bgAttachment',
            'fontSize',
            'fontWeight',
            'fontStyle',
            'textTransform',
            'textAlign',
            'className',
            'borderSize',
            'borderStyle',
            'borderColor',
            'borderRadius',
            'shadowSize',
            'shadowColor',
        ];
        $namesClasses = collect($names)->map(fn($name) => data_get($attributes, $name))->filter(fn($class) => !empty($class))->toArray();
        $spacingClasses = spacing_classes($block);
        $allClasses = [
            ...$namesClasses,
            ...$spacingClasses,
            ...$merge,
        ];
        $classes = array_filter($allClasses, fn($cls) => !empty($cls));
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
/*if (!function_exists('block_class')) {
    function block_class(array $atts)
    {
        $atts = collect($atts);
        // text
        $color = $atts->get('color');
        $fontSize = $atts->get('fontSize');
        $fontWeight = $atts->get('fontWeight');
        $fontStyle = $atts->get('fontStyle');
        $textTransform = $atts->get('textTransform');
        $textAlign = $atts->get('textAlign');

        // background
        $bgColor = $atts->get('bgColor');
        $bgSize = $atts->get('bgSize');
        $bgPosition = $atts->get('bgPosition');
        $bgAttachment = $atts->get('bgAttachment');

        // css classes
        $className = $atts->get('className');
        return css_classes([
            // text
            $color => $color,
            $fontSize => $fontSize,
            $fontWeight => $fontWeight,
            $fontStyle => $fontStyle,
            $textTransform => $textTransform,
            $textAlign => $textAlign,

            // background
            $bgColor => $bgColor,
            $bgSize => $bgSize,
            $bgPosition => $bgPosition,
            $bgAttachment => $bgAttachment,

            // css classes
            $className => $className,
        ]);
    }
}

if (!function_exists('block_style')) {
    function block_style(array $atts)
    {
        $atts = collect($atts);
        $bgImage = $atts->get('bgImage');
        $style = $atts->get('style');
        return Arr::toCssStyles([
            ...($bgImage ? ['background-image' => "url('{$bgImage}')"] : []),
            ...($style ? $style : []),
        ]);
    }
}*/
if (!function_exists('block_atts')) {
    function block_atts($block): Collection
    {
        $type = data_get($block, 'type');
        return collect(array_merge(block_defaults($type), data_get($block, 'attributes', [])));
    }
}
if (!function_exists('pre')) {
    function pre($data)
    {
        return view('components.dump', ['data' => $data]);
    }
}
if (!function_exists('blocks')) {
    function blocks($blocks)
    {
        return is_array($blocks) ? implode('', arr_map($blocks, fn($block) => block($block))) : '';
    }
}
if (!function_exists('block')) {
    function block($block)
    {
        // return pre($block);
        // return pre(block_classes($block));
        $type = data_get($block, 'type');
        $atts = block_atts($block);
        return match ($type) {
            'container' => block_container($block),
            'paragraph' => block_paragraph($block),
            'button' => block_button($block),
            'heading' => block_heading($block),
            // 'hero' => block_hero($block),
            // 'posts_grid' => posts_grid($atts),
            /* 'quotes_grid' => quotes_grid($data),
            'quotes_gallery' => quotes_gallery($data),
            'books_grid' => books_grid($data),
            'categories_grid' => categories_grid($data),
            'authors_grid' => authors_grid($data),
            'text' => text_block($data),
            'button' => button_block($data),
            'hero' => hero($data),
            'carousel' => carousel($data), */
            default => view('components.dump', ['data' => $block]),
        };
    }
}
if (!function_exists('block_container')) {
    function block_container($block)
    {
        $atts = block_atts($block);
        $children = data_get($block, 'children', []);
        return container([
            'class' => block_classes($block, [
                $atts->get('type'),
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
            'class' => block_classes($block),
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
if (!function_exists('posts_grid')) {
    function posts_grid($options)
    {
        $posts = get_posts($options);
        return view('components.posts-grid', [
            ...$options,
            ...[
                'posts' => $posts,
            ]
        ]);
    }
}

if (!function_exists('quotes_grid')) {
    function quotes_grid($options = [])
    {
        $ops = collect(array_merge(block_defaults('quotes_grid'), $options));
        $quotes = get_quotes($ops->toArray());
        $title = $ops->get('title');
        $showTitle = (bool) $ops->get('show_title');
        $className = $ops->get('className');
        return view('components.quotes-grid', [
            'title' => $showTitle ? $title : null,
            'class' => $className,
            'quotes' => $quotes,
        ]);
    }
}
if (!function_exists('quotes_gallery')) {
    function quotes_gallery($options = [])
    {
        $ops = collect(array_merge(block_defaults('quotes_gallery'), $options));
        $quotes = get_quotes($ops->toArray());
        $title = $ops->get('title');
        $showTitle = (bool) $ops->get('show_title');
        $className = $ops->get('className');
        return view('components.quotes-gallery', [
            'title' => $showTitle ? $title : null,
            'class' => $className,
            'quotes' => $quotes,
        ]);
    }
}
if (!function_exists('books_grid')) {
    function books_grid($options = [])
    {
        $ops = collect(array_merge(block_defaults('books_grid'), $options));
        $books = get_books($ops->toArray());
        $title = $ops->get('title');
        $showTitle = (bool) $ops->get('show_title');
        $className = $ops->get('className');
        return view('components.books-grid', [
            'title' => $showTitle ? $title : null,
            'class' => $className,
            'books' => $books,
        ]);
    }
}
if (!function_exists('categories_grid')) {
    function categories_grid($options = [])
    {
        $ops = collect(array_merge(block_defaults('categories_grid'), $options));
        $categories = get_categories($ops->toArray());

        $title = $ops->get('title');
        $showTitle = (bool) $ops->get('show_title');
        $className = $ops->get('className');
        return view('components.categories-grid', [
            'title' => $showTitle ? $title : null,
            'class' => $className,
            'categories' => $categories,
        ]);
    }
}
if (!function_exists('authors_grid')) {
    function authors_grid($options = [])
    {
        $ops = collect(array_merge(block_defaults('authors_grid'), $options));
        $authors = get_authors($ops->toArray());
        $title = $ops->get('title');
        $showTitle = (bool) $ops->get('show_title');
        $className = $ops->get('className');
        return view('components.authors-grid', [
            'title' => $showTitle ? $title : null,
            'class' => $className,
            'authors' => $authors,
        ]);
    }
}
if (!function_exists('text_block')) {
    function text_block($data)
    {
        $ops = collect($data);
        return container([
            'tag' => 'p',
            'class' => $ops->get('className', ''),
            'content' => $ops->get('content', '')
        ]);
    }
}
if (!function_exists('button_block')) {
    function button_block($options = [])
    {
        $ops = collect(array_merge(block_defaults('button'), $options));
        return view('components.button', [
            'label' => $ops->get('label'),
            'icon' => $ops->get('icon'),
            'url' => $ops->get('url'),
            'target' => $ops->get('target'),
            'color' => $ops->get('color'),
            'outline' => (bool) $ops->get('outline'),
            'gradient' => (bool) $ops->get('gradient'),
            'pill' => (bool) $ops->get('pill'),
            'size' => $ops->get('size'),
            'class' => $ops->get('className'),
        ]);
    }
}
if (!function_exists('hero')) {
    function hero($options = [])
    {
        $ops = collect(array_merge(block_defaults('hero'), $options));
        return view('components.hero', [
            'fullscreen' => $ops->get('fullscreen'),
            'theme' => $ops->get('theme'),
            'title' => $ops->get('title'),
            'subtitle' => $ops->get('subtitle'),
            'text' => $ops->get('text'),
            'color' => $ops->get('color'),
            'bgcolor' => $ops->get('bgcolor'),
            'image' => $ops->get('image'),
            'class' => $ops->get('className'),
            'actions' => $ops->get('children', []),
        ]);
    }
}
if (!function_exists('carousel')) {
    function carousel($options = [])
    {
        $ops = collect(array_merge(block_defaults('carousel'), $options));
        return view('components.carousel', [
            'autoplay' => (bool) $ops->get('autoplay', true),
            'controls' => (bool) $ops->get('controls', true),
            'indicators' => (bool) $ops->get('indicators', true),
            'transition' => $ops->get('transition', 'slide'),
            'duration' => $ops->get('duration'),
            'interval' => $ops->get('interval'),
            'class' => $ops->get('className'),
            'slides' => $ops->get('children', []),
        ]);
    }
}
