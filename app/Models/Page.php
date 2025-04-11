<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Route;

class Page extends Post
{
    use HasFactory;
    protected $table = 'posts';
    protected static function booted()
    {
        static::addGlobalScope('page', function (Builder $builder) {
            $builder->where('type', 'page');
        });
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            $page->type = 'page';
        });

        static::updating(function ($page) {
            $page->type = 'page';
        });
    }

    public function scopePage($query)
    {
        return $query->where('type', 'page');
    }

    public function scopeSlug($query, $slug)
    {
        return $query->firstWhere('slug', $slug);
    }

    /*public function getPermalinkAttribute()
    {
        return !empty($this->id) && Route::has('page') ? route('page', $this) : null;
    }*/
}
