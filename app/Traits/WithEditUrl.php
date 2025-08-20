<?php

namespace App\Traits;

use App\Models\Post;
use Illuminate\Support\Facades\Route;

trait WithEditUrl
{
    public function getEditUrlAttribute()
    {
        return Route::has("dashboard.{$this->getTable()}.edit") ? route("dashboard.{$this->getTable()}.edit", $this) : null;
    }
}
