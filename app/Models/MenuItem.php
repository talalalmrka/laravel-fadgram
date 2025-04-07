<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    /** @use HasFactory<\Database\Factories\MenuItemFactory> */
    use HasFactory;
    protected $fillable = [
        'menu_id',
        'parent_id',
        'name',
        'icon',
        'order',
        'type',
        'page_id',
        'post_id',
        'category_id',
        'url',
        'class_name',
        'navigate',
        'target',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($menuItem) {
            if ($menuItem->menu_id) {
                $menu = Menu::find($menuItem->menu_id);
                if ($menu) {
                    $menuItem->order = $menu->newItemOrder();
                }
            }
        });

        static::updating(function ($menuItem) {});
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
    public function isSubItem()
    {
        return !empty($this->parent);
    }
    public function isPage()
    {
        return $this->type === 'page';
    }
    public function isPost()
    {
        return $this->type === 'post';
    }
    public function isCategory()
    {
        return $this->type === 'category';
    }
    public function isCustom()
    {
        return $this->type == 'custom';
    }
    public function getParentNameAttribute()
    {
        return $this->parent?->name;
    }
    public function getHrefAttribute()
    {
        return match ($this->type) {
            'page' => $this->page?->permalink,
            'post' => $this->post?->permalink,
            'category' => $this->category?->permalink,
            default => $this->url,
        };
    }
}
