<?php

namespace App\Models;

use App\Traits\Favoritable;
use App\Traits\HasAuthor;
use App\Traits\HasCategories;
use App\Traits\HasComments;
use App\Traits\HasMeta;
use App\Traits\HasNextPrev;
use App\Traits\HasQuotes;
use App\Traits\HasRelated;
use App\Traits\HasSlug;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasThumbnail;
use App\Traits\WithDate;
use App\Traits\WithExcerpt;
use App\Traits\WithPermalink;
use App\Traits\WithSeo;
use App\Traits\WithShare;
use App\Traits\WithStatus;
use App\Traits\WithTemplate;
use App\Traits\WithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Book extends Model implements HasMedia
{
    use HasFactory,
        InteractsWithMedia,
        HasThumbnail,
        HasMeta,
        HasCategories,
        HasAuthor,
        HasTags,
        HasSlug,
        WithPermalink,
        WithDate,
        WithTemplate,
        WithStatus,
        WithViews,
        WithExcerpt,
        HasRelated,
        WithSeo,
        WithViews,
        Favoritable,
        HasQuotes,
        HasComments,
        HasNextPrev,
        WithShare;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'status',
        'content',
    ];
    protected $appends = [
        'permalink',
        'excerpt',
        'file_type',
        'file_size',
        'pages',
        'year',
        'downloads',
        'reads',
    ];

    public function thumbnailFallbackUrl(): Attribute
    {
        return Attribute::get(fn() => asset('assets/images/book.svg'));
    }
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
        $this->addMediaCollection('file')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }
    public function editUrl(): Attribute
    {
        return Attribute::get(fn() => route_has('dashboard.books.edit') ? route('dashboard.books.edit', $this) : null);
    }
    protected function file(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMedia('file'));
    }

    protected function fileType(): Attribute
    {
        return Attribute::get(fn() => $this->file?->type);
    }
    protected function fileSize(): Attribute
    {
        return Attribute::get(fn() => $this->file?->humanReadableSize);
    }
    protected function pages(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('pages'));
    }
    protected function year(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('year'));
    }
    protected function downloads(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('downloads'));
    }
    protected function downloadsFormatted(): Attribute
    {
        return Attribute::get(fn() => human_number($this->downloads));
    }
    protected function reads(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('reads'));
    }
    protected function readsFormatted(): Attribute
    {
        return Attribute::get(fn() => human_number($this->reads));
    }
    public function downloadsPlus()
    {
        $downloads = intval($this->downloads) + 1;
        $this->updateMeta('downloads', $downloads);
    }
    public function readsPlus()
    {
        $reads = intval($this->reads) + 1;
        $this->updateMeta('reads', $reads);
    }
}
