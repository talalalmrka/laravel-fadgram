<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait WithTemplate
{
    public function template(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('template', 'curve'));
    }
    public function layout(): Attribute
    {
        $layout = "layouts.{$this->template}";
        return Attribute::get(fn() => view()->exists($layout) ? $layout : "layouts.app");
    }
}
