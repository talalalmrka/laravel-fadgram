<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait WithPermalink
{
    public function permalink(): Attribute
    {
        $singular = singular($this->getTable());
        return Attribute::get(fn() => !empty($this->id) && route_has($singular) ? route($singular, $this->slug) : null);
    }
}
