<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheItem extends Model
{
    protected $table = 'cache';
    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['key', 'value', 'expiration'];

    protected $casts = [
        'expiration' => 'datetime',
    ];

    /* protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            Cache::forget($item->key);
        });
    } */
}
