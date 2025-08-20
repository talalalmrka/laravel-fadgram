<?php

use App\Models\Category;

if (!function_exists('breadcrumbs')) {
    /**
     * Generate breadcrumbs based on the current route and parameters.
     * @return array
     */
    function breadcrumbs()
    {

        $route = request()->route();
        if (!$route) return [];
        $name = $route->getName();
        $params = $route->parameters();
        $crumbs = [];
        if (is_home()) {
            return null;
        }
        // Always start with Home
        $crumbs[] = [
            'icon' => 'bi-house-fill',
            'label' => __('Home'),
            'url' => route('home'),
        ];
        switch ($name) {
            case 'blog':
                $crumbs[] = [
                    'label' => __('Blog'),
                    'url' => route('blog'),
                ];
                break;
            case 'books':
                $crumbs[] = [
                    'label' => __('Books'),
                    'url' => route('books'),
                ];
                break;
            case 'book':
                $crumbs[] = [
                    'label' => __('Books'),
                    'url' => route('books'),
                ];
                $book = $params['book'] ?? null;
                if ($book instanceof \App\Models\Book) {
                    // Add categories if any
                    if ($book->categories && $book->categories->count()) {
                        foreach ($book->categories as $category) {
                            $crumbs[] = [
                                'icon' => 'bi-folder',
                                'label' => $category->name,
                                'url' => $category->permalink,
                            ];
                        }
                    }
                    $crumbs[] = [
                        'icon' => 'bi-book',
                        'label' => $book->name,
                    ];
                }
                break;
            case 'authors':
                $crumbs[] = [
                    'icon' => 'bi-person',
                    'label' => __('Authors'),
                ];
                break;
            case 'author':
                $crumbs[] = [
                    'icon' => 'bi-person',
                    'label' => __('Authors'),
                    'url' => route('authors'),
                ];
                $author = $params['author'] ?? null;
                if ($author instanceof \App\Models\Author) {
                    $crumbs[] = [
                        'label' => $author->name,
                    ];
                }
                break;
            case 'user':
                $user = $params['user'] ?? null;
                if ($user instanceof \App\Models\User) {
                    $crumbs[] = [
                        'label' => $user->display_name,
                    ];
                }
                break;
            case 'quotes':
                $crumbs[] = [
                    'icon' => 'bi-quote',
                    'label' => __('Quotes'),
                    'url' => route('quotes'),
                ];
                break;
            case 'quote':
                $crumbs[] = [
                    'icon' => 'bi-quote',
                    'label' => __('Quotes'),
                    'url' => route('quotes'),
                ];
                $quote = $params['quote'] ?? null;
                if ($quote instanceof \App\Models\Quote) {
                    // Add categories if any
                    if ($quote->categories && $quote->categories->count()) {
                        foreach ($quote->categories as $category) {
                            $crumbs[] = [
                                'icon' => 'bi-folder',
                                'label' => $category->name,
                                'url' => $category->permalink,
                            ];
                        }
                    }
                    $crumbs[] = [
                        'label' => $quote->name,
                    ];
                }
                break;
            case 'post':
                $crumbs[] = [
                    'icon' => 'bi-newspaper',
                    'label' => __('Blog'),
                    'url' => route('blog'),
                ];
                $post = $params['post'] ?? null;
                if ($post instanceof \App\Models\Post) {
                    // Add categories if any
                    if ($post->categories && $post->categories->count()) {
                        foreach ($post->categories as $category) {
                            $crumbs[] = [
                                'icon' => 'bi-folder',
                                'label' => $category->name,
                                'url' => $category->permalink,
                            ];
                        }
                    }
                    $crumbs[] = [
                        'icon' => 'bi-newspaper',
                        'label' => $post->name,
                    ];
                }
                break;
            case "categories":
                $crumbs[] = [
                    'label' => __('Categories')
                ];
                break;
            case "category":
                $category = data_get($params, 'category');
                if ($category instanceof Category) {
                    $crumbs[] = [
                        'label' => $category->name,
                    ];
                }
                break;
            case "gallery":
                $crumbs[] = [
                    'label' => __('Gallery'),
                ];
                break;
            case "favorites":
                $crumbs[] = [
                    'label' => __('Favorites'),
                ];
                break;

            default:
                // fallback: just show Home
                break;
        }
        return $crumbs;
    }
}
