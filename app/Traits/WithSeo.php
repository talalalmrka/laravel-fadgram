<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait WithSeo
{
    public function seoTitle(): Attribute
    {
        $siteName = site_name();
        return Attribute::get(fn() => $this->getMeta('seo_title', "{$this->name} | $siteName"));
    }
    public function seoDescription(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('seo_description', $this->getExcerpt(160, '', true)));
    }
}
