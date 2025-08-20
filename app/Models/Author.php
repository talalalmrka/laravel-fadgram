<?php

namespace App\Models;

use App\Models\Quote;
use App\Traits\Favoritable;
use App\Traits\HasCategories;
use App\Traits\HasComments;
use App\Traits\HasMeta;
use App\Traits\HasNextPrev;
use App\Traits\HasSlug;
use App\Traits\HasTags;
use App\Traits\HasThumbnail;
use App\Traits\HasUser;
use App\Traits\WithDate;
use App\Traits\WithEditUrl;
use App\Traits\WithExcerpt;
use App\Traits\WithPermalink;
use App\Traits\WithSeo;
use App\Traits\WithShare;
use App\Traits\WithStatus;
use App\Traits\WithTemplate;
use App\Traits\WithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Author extends Model implements HasMedia
{
    use HasFactory,
        InteractsWithMedia,
        HasUser,
        HasThumbnail,
        HasMeta,
        HasCategories,
        HasTags,
        HasSlug,
        WithPermalink,
        WithDate,
        WithTemplate,
        WithStatus,
        WithViews,
        WithExcerpt,
        WithEditUrl,
        WithSeo,
        Favoritable,
        HasComments,
        HasNextPrev,
        WithShare;
    protected $fillable = [
        'name',
        'slug',
        'status',
        'content',
    ];
    protected $appends = [
        'permalink',
        'excerpt',
        'quotes_count',
        'books_count',
    ];

    public function quotes()
    {
        return $this->morphedByMany(Quote::class, 'model', 'model_author');
    }
    public function quotesCount(): Attribute
    {
        return Attribute::get(fn() => number_format($this->quotes()->count()));
    }
    public function books()
    {
        return $this->morphedByMany(Book::class, 'model', 'model_author');
    }
    public function booksCount(): Attribute
    {
        return Attribute::get(fn() => number_format($this->books()->count()));
    }

    public function getThumbnailFallbackUrlAttribute()
    {
        return asset('assets/images/profile.svg');
    }
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
    }
}
