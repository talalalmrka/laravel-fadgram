<?php

namespace App\Models;

use App\Models\Post;
use App\Traits\Favoritable;
use App\Traits\HasAuthor;
use App\Traits\HasMeta;
use App\Traits\HasNextPrev;
use App\Traits\HasSlug;
use App\Traits\HasThumbnail;
use App\Traits\WithDate;
use App\Traits\WithEditUrl;
use App\Traits\WithExcerpt;
use App\Traits\WithPermalink;
use App\Traits\WithSeo;
use App\Traits\WithShare;
use App\Traits\WithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory,
        InteractsWithMedia,
        HasThumbnail,
        HasMeta,
        WithDate,
        WithEditUrl,
        HasAuthor,
        HasSlug,
        WithPermalink,
        WithDate,
        WithViews,
        WithExcerpt,
        WithSeo,
        Favoritable,
        HasNextPrev,
        WithShare;
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
    public function parentName(): Attribute
    {
        return Attribute::get(fn() => $this->parent?->name);
    }
    public function parents()
    {
        $parents = collect();
        $category = $this->parent;
        while ($category) {
            $parents->push($category);
            $category = $category->parent;
        }
        return $parents;
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('id', 'asc');
    }
    public function posts()
    {
        return $this->morphedByMany(
            Post::class,
            'model',
            'model_category'
        );
    }
    public function postsCount(): Attribute
    {
        return Attribute::get(fn() => $this->posts()->status('publish')->count());
    }
    public function books()
    {
        return $this->morphedByMany(
            Book::class,
            'model',
            'model_category'
        );
    }
    public function booksCount(): Attribute
    {
        return Attribute::get(fn() => $this->books()->status('publish')->count());
    }
    public function quotes()
    {
        return $this->morphedByMany(
            Quote::class,
            'model',
            'model_category'
        );
    }
    public function quotesCount(): Attribute
    {
        return Attribute::get(fn() => $this->quotes()->status('publish')->count());
    }
    public function quoteImages()
    {
        return $this->morphedByMany(
            QuoteImage::class,
            'model',
            'model_category'
        );
    }
    public function quoteImagesCount(): Attribute
    {
        return Attribute::get(fn() => $this->quoteImages()->count());
    }
    public function scopeTop($query)
    {
        return $query->where('parent_id', null);
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
        return asset('assets/images/category.svg');
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

    public function scopeCategory($query)
    {
        return $query->where('type', 'category');
    }
    public function scopeTag($query)
    {
        return $query->where('type', 'tag');
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
