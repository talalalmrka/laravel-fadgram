<?php

namespace App\Models;

use App\Traits\HasMeta;
use App\Traits\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class Category extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, InteractsWithMedia, HasThumbnail, HasMeta;
    protected $fillable = [
        'name',
        'slug',
        'type',
        'parent_id',
        'description',
    ];
    protected $appends = [
        'permalink',
        'thumbnails',
        'thumbnail',

    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function getParentNameAttribute()
    {
        return $this->parent?->name;
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('id', 'asc');
    }
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'model', 'model_category');
    }
    public function scopeTop($query)
    {
        return $query->where('parent_id', 'null');
    }
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%");
    }
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
    public function getThumbnailFallbackUrlAttribute()
    {
        return asset('assets/img/category.png');
    }
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
    }
    public function getPathAttribute()
    {
        $segments = [];
        $category = $this;

        while ($category) {
            $segments[] = $category->slug;
            $category = $category->parent;
        }

        return implode('/', array_reverse($segments));
    }
    public function parentsCount()
    {
        $count = 0;
        $category = $this;
        while ($category) {
            $category = $category->parent;
            if ($category) {
                $count++;
            }
        }
        return $count;
    }
    public function getLabelAttribute()
    {
        return str_repeat('-', $this->parentsCount()) . $this->name;
    }
    public function getPermalinkAttribute()
    {
        return !empty($this->id) ? (Route::has('category') ? route('post', $this) : null) : null;
    }
    public static function generateSlug($name, $separator = '-', $language = 'en', $dictionary = ['@' => 'at']): string
    {
        $slug = Str::slug($name, $separator, $language, $dictionary);
        $originalSlug = $slug;
        $count = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        return $slug;
    }
    public function getFullDescriptionAttribute()
    {
        if (!empty($this->description)) {
            return $this->description;
        }

        $categoryNames = [$this->name];
        $parentCategory = $this->parent;

        while ($parentCategory) {
            $categoryNames[] = $parentCategory->name;
            $parentCategory = $parentCategory->parent;
        }

        return implode(' ', array_reverse($categoryNames));
    }
    public function scopeCategory($query)
    {
        return $query->where('type', 'category');
    }
    public function hasAnyChild($categories)
    {
        $categoryIds = $this->resolveCategoryIds($categories);
        foreach ($categoryIds as $categoryId) {
            if ($this->children()->where('id', $categoryId)->exists()) {
                return true;
            }
            foreach ($this->children as $child) {
                if ($child->hasAnyChild($categoryId)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function resolveCategoryIds($categories): array
    {
        if ($categories instanceof Collection) {
            return $categories->pluck('id')->all();
        }

        if ($categories instanceof Category) {
            return [$categories->id];
        }

        if (is_array($categories)) {
            $categories = array_filter(Arr::flatten($categories));
            return Category::whereIn('slug', $categories)
                ->orWhereIn('id', $categories)
                ->pluck('id')
                ->all();
        }

        return [Category::where('slug', $categories)->orWhere('id', $categories)->value('id')];
    }
}
