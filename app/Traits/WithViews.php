<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait WithViews
{
    protected function views(): Attribute
    {
        return Attribute::get(fn() => intval($this->getMeta('views', 0)));
    }
    protected function viewsFormatted(): Attribute
    {
        return Attribute::get(fn() => human_number($this->views));
    }
    public function viewsPlus()
    {
        $views = $this->views + 1;
        $this->updateMeta('views', $views);
    }
}
