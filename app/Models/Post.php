<?php

namespace App\Models;

use App\Http\Controllers\PageBuilderController;
use App\Traits\Favoritable;
use App\Traits\HasAuthor;
use App\Traits\HasCategories;
use App\Traits\HasComments;
use App\Traits\HasMeta;
use App\Traits\HasNextPrev;
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
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
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
        Favoritable,
        HasComments,
        HasNextPrev,
        WithShare;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'type',
        'status',
        'content',
    ];
    protected $appends = [
        'permalink',
        'excerpt',
        'blocks',
    ];
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
        $this->addMediaCollection('images')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'image/svg',
            ])->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('sm')
                    ->width(400)
                    ->height(255)
                    ->format('webp')
                    ->nonQueued();
                $this
                    ->addMediaConversion('md')
                    ->width(600)
                    ->height(337.5)
                    ->format('webp')
                    ->nonQueued();
                $this
                    ->addMediaConversion('lg')
                    ->width(800)
                    ->height(450)
                    ->format('webp')
                    ->nonQueued();
            });
    }
    public function thumbnailFallbackUrl(): Attribute
    {
        return Attribute::get(fn() => asset('assets/images/post-thumbnail.svg'));
    }
    public function editUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->id) {
                if ($this->type) {
                    if ($this->type === 'page' && (bool) $this->getMeta('builder_enabled')) {
                        return route('builder', $this->id);
                    }
                    $plural = plural($this->type);
                    if (route_has("dashboard.$plural.edit")) {
                        return route("dashboard.$plural.edit", $this);
                    }
                }
                route_has("dashboard.posts.edit") ? route('dashboard.posts.edit', $this) : null;
            } else {
                return null;
            }
        });
    }
    public function seoTitle(): Attribute
    {
        $siteName = site_name();
        return Attribute::get(fn() => $this->getMeta('seo_title', "{$this->name} | $siteName"));
    }
    public function seoDescription(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('seo_description', $this->getExcerpt(160, '', true)));
    }
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
    public function scopePost($query)
    {
        return $query->where('type', 'post');
    }
    public function scopePage($query)
    {
        return $query->where('type', 'page');
    }
    public static function resolveBlocks($blocks)
    {
        return arr_map($blocks, function ($block) {
            $block = array_merge($block, [
                'id' => uniqid('block-'),
            ]);
            $attributes = data_get($block, 'attributes', []);
            $block['attributes'] = [
                ...PageBuilderController::blockDefaults($block['type']),
                ...$attributes,
            ];
            $children = data_get($block, 'children');
            if ($children && is_array($children) && !empty($children)) {
                $block['children'] = static::resolveBlocks($children);
            }
            return $block;
        });
    }
    public function blocks(): Attribute
    {
        return Attribute::get(function () {
            $blocks = is_array($this->getMeta('blocks')) ? $this->getMeta('blocks') : [];
            return static::resolveBlocks($blocks);
        });
    }

    public function saveBlocks(array $blocks): bool
    {
        return $this->updateMeta('blocks', $blocks);
    }
}
