<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'position',
        'class_name',
    ];
    public function items()
    {
        return $this->hasMany(MenuItem::class)->where('parent_id', null)->orderBy('order');
    }
    public function itemsCount()
    {
        return $this->items()->count();
    }
    public function newItemOrder()
    {
        return $this->itemsCount();
    }
    public function scopePosition($query, $position)
    {
        return $query->where('position', $position);
    }
    public function render()
    {
        return view('components.nav-menu', ['menu' => $this]);
    }
}
