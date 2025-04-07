<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('route_has')) {
    function route_has(string|array $name)
    {
        return Route::has($name);
    }
}

if (!function_exists('home_url')) {
    function home_url($path = '')
    {
        return config('app.url') . $path;
    }
}
