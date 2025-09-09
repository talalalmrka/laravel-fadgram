<?php

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

if (!function_exists('route_has')) {
    /**
     * Check if a route with the given name exists.
     *
     * @param string|array $name Route name or array of names.
     * @return bool
     */
    function route_has(string|array $name)
    {
        return Route::has($name);
    }
}

if (!function_exists('home_url')) {
    /**
     * Get the home URL with an optional appended path.
     *
     * @param string $path Optional path to append to the base URL.
     * @return string
     */
    function home_url($path = '')
    {
        return config('app.url') . $path;
    }
}

if (!function_exists('arr_map')) {
    /**
     * Apply a callback to each item in the array and return the resulting array.
     *
     * @param array $array The array to map over.
     * @param callable $callback The callback to apply.
     * @return array
     */
    function arr_map(array $array, callable $callback)
    {
        return Arr::map($array, $callback);
    }
}

if (!function_exists('arr_filter')) {
    /**
     * Filter elements of an array using a callback function.
     *
     * @param array $array The array to filter.
     * @param callable|null $callback The callback to use for filtering. If null, removes falsey values.
     * @param int $mode Flag determining what arguments are sent to callback.
     * @return array
     */
    function arr_filter(array $array, ?callable $callback, int $mode = 0)
    {
        return array_filter($array, $callback, $mode);
    }
}

if (!function_exists('arr_first')) {
    /**
     * Get the first element in an array passing a given truth test.
     *
     * @param array $array The array to search.
     * @param callable|null $callback The callback to determine if the item is valid. If null, returns the first element.
     * @param mixed $default The default value to return if no valid item is found.
     * @return mixed
     */
    function arr_first(array $array, ?callable $callback, $default = 0)
    {
        return Arr::first($array, $callback, $default);
    }
}
if (!function_exists('arr_where')) {
    /**
     * Filter the array using the given callback and return only the items that pass the test.
     *
     * @param array $array The array to filter.
     * @param callable $callback The callback to use for filtering.
     * @return array
     */
    function arr_where(array $array, callable $callback)
    {
        return Arr::where($array, $callback);
    }
}
if (!function_exists('arr_only')) {
    function arr_only($array, $keys)
    {
        return Arr::only($array, $keys);
    }
}

if (!function_exists('assets')) {
    function assets($path, $secure = null)
    {
        return asset("assets/$path", $secure);
    }
}
if (!function_exists('images')) {
    function images($path, $secure = null)
    {
        return asset("assets/images/$path", $secure);
    }
}
if (!function_exists('fonts')) {
    function fonts($path, $secure = null)
    {
        return asset("assets/fonts/$path", $secure);
    }
}

if (!function_exists('singular')) {
    function singular(string $string)
    {
        return Str::singular($string);
    }
}
if (!function_exists('plural')) {
    function plural(string $string, $count = 2)
    {
        return Str::plural($string, $count);
    }
}

if (!function_exists('container')) {
    function container($data = [])
    {
        return view('components.container', $data);
    }
}

if (!function_exists('a')) {
    function a($data = [])
    {
        return view('components.link', $data);
    }
}
if (!function_exists('img')) {
    function img($data)
    {
        return view('components.image', $data);
    }
}
if (!function_exists('status_badge')) {
    function status_badge($status)
    {
        $colors = [
            'publish' => 'green',
            'draft' => 'teal',
            'trash' => 'red',
        ];
        $color = data_get($colors, $status);
        $icons = [
            'publish' => 'bi-check2-circle',
            'draft' => 'bi-clock',
            'trash' => 'bi-trash',
        ];
        $icon = data_get($icons, $status);
        $label = ucfirst($status);
        return badge([
            'icon' => $icon,
            'label' => $label,
            'color' => $color,
            'outline' => true,
            'pill' => true,
        ]);
    }
}
if (!function_exists('post_type_badge')) {
    function post_type_badge($type)
    {
        $colors = [
            'post' => 'green',
            'page' => 'teal',
            'quote' => 'emerald',
            'book' => 'violet',
        ];
        $color = data_get($colors, $type);
        $icons = [
            'publish' => 'bi-newspaper',
            'page' => 'bi-file-earmark-text',
            'quote' => 'bi-quote',
            'book' => 'bi-book',
        ];
        $icon = data_get($icons, $type);
        $label = ucfirst($type);
        return badge([
            'icon' => $icon,
            'label' => __($label),
            'color' => $color,
            'outline' => true,
            'pill' => true,
        ]);
    }
}
if (!function_exists('template_badge')) {
    function template_badge($template)
    {
        $colors = [
            'default' => 'green',
            'cover' => 'teal',
            'curve' => 'violet',
        ];
        $color = data_get($colors, $template);
        $label = ucfirst($template);
        return badge([
            'label' => __($label),
            'color' => $color,
            'outline' => true,
            'pill' => true,
        ]);
    }
}
if (!function_exists('rating')) {
    function rating($data = [])
    {
        return view('components.rating', $data);
    }
}
if (!function_exists('is_home')) {
    function is_home()
    {
        return request()->routeIs('home');
    }
}
if (!function_exists('is_blog')) {
    function is_blog()
    {
        return request()->routeIs('blog');
    }
}
if (!function_exists('is_post')) {
    function is_post()
    {
        return request()->routeIs('post');
    }
}
if (!function_exists('is_quotes')) {
    function is_quotes()
    {
        return request()->routeIs('quotes');
    }
}
if (!function_exists('is_quote')) {
    function is_quote()
    {
        return request()->routeIs('quote');
    }
}
if (!function_exists('is_books')) {
    function is_books()
    {
        return request()->routeIs('books');
    }
}
if (!function_exists('is_book')) {
    function is_book()
    {
        return request()->routeIs('book');
    }
}
if (!function_exists('is_author')) {
    function is_author()
    {
        return request()->routeIs('author');
    }
}
if (!function_exists('is_user')) {
    function is_user()
    {
        return request()->routeIs('user');
    }
}
if (!function_exists('is_debug')) {
    function is_debug(): bool
    {
        return config('app.debug', false);
    }
}
if (!function_exists('error_message')) {
    function error_message(\Exception $e, $message = '')
    {
        return is_debug() ? "$message: {$e->getMessage()}" : $message;
    }
}

if (!function_exists('human_number')) {
    function human_number($num)
    {
        $num = (int) $num;
        if ($num < 1000) {
            return (string) $num;
        }
        $units = ['', 'K', 'M'];
        $i = 0;
        while ($num >= 1000 && $i < count($units) - 1) {
            $num /= 1000;
            $i++;
        }
        // Show one decimal if not integer, else no decimal
        return $num == (int)$num
            ? number_format($num, 0) . $units[$i]
            : number_format($num, 1) . $units[$i];
    }
}

if (!function_exists('str_slug')) {
    function str_slug($title, $separator = '-', $language = 'en', $dictionary = ['@' => 'at'])
    {
        return Str::slug($title, $separator, $language, $dictionary);
    }
}
if (!function_exists('str_limit')) {
    function str_limit($value, $limit = 100, $end = '...', $preserveWords = false)
    {
        return Str::limit($value, $limit, $end, $preserveWords);
    }
}
if (!function_exists('colored_title')) {
    function colored_title($title)
    {
        $words = explode(' ', $title);
        if (count($words) > 1) {
            $lastWord = array_pop($words); // Get and remove the last word
            $words[] = "<span class=\"text-primary\">$lastWord</span>"; // Add the last word with class
        }
        return implode(' ', $words);
    }
}

if (!function_exists('today')) {
    function today()
    {
        return Carbon::today();
    }
}

if (!function_exists('today_formatted')) {
    function today_formatted()
    {
        return date_format(today(), app_date_format());
    }
}
