<?php

namespace App\Http\Controllers;

use App\Models\Font;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    public function font()
    {
        return Font::css();
    }
    public function colorRange($name, $color)
    {
        $css = '';
        $css .= "--color-$name: var(--color-$color-600);";
        collect(range(1, 9))->each(function ($i) use ($name, $color, &$css) {
            $n = $i * 100;
            $css .= "--color-$name-$n: var(--color-$color-$n);";
        });
        $css .= "--color-$name-950: var(--color-$color-950);";
        return $css;
    }
    public function colors()
    {
        $primary = get_option('color_primary');
        $secondary = get_option('color_secondary');
        $css = '';
        if (!empty($primary) || !empty($secondary)) {
            $css .= ':root,:host {';
            if (!empty($primary)) {
                $css .= $this->colorRange('primary', $primary);
            }
            if (!empty($secondary)) {
                $css .= $this->colorRange('secondary', $secondary);
            }
            $css .= '}';
        }
        return $css;
    }
    public function index()
    {
        $css = $this->font();
        $css .= $this->colors();
        return response()->make($css, 200, ['Content-Type' => 'text/css']);
    }
}
