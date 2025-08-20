<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = self::generateSlug($model->name);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = self::generateSlug($model->name);
            }
        });
    }

    public static function generateSlug($name, $separator = '-', $language = 'en', $dictionary = ['@' => 'at']): string
    {
        $slug = Str::slug($name, $separator, $language, $dictionary);
        $originalSlug = $slug;
        $count = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . $separator . $count++;
        }
        return $slug;
    }
    public function scopeSlug($query, $slug)
    {
        return $query->firstWhere('slug', $slug);
    }
}
