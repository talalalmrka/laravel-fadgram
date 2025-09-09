<?php

namespace App\Models;

use App\Traits\Favoritable;
use App\Traits\HasAuthor;
use App\Traits\HasCategories;
use App\Traits\HasComments;
use App\Traits\HasMeta;
use App\Traits\HasNextPrev;
use App\Traits\HasSlug;
use App\Traits\HasTags;
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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Quote extends Model implements HasMedia
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
        WithSeo,
        Favoritable,
        HasComments,
        HasNextPrev,
        WithShare;
    protected $fillable = [
        'user_id',
        'quote_image_id',
        'name',
        'slug',
        'status',
        'content',
    ];
    protected $appends = [
        'permalink',
        'excerpt',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            if (empty($quote->name)) {
                $quote->name = Str::limit($quote->content, 15, '', true);
            }
            if (empty($quote->slug)) {
                $quote->slug = self::generateSlug($quote->name);
            }
        });
        static::updating(function ($quote) {
            if (empty($quote->name)) {
                $quote->name = Str::limit($quote->content, 15, '', true);
            }
            if (empty($quote->slug)) {
                $quote->slug = self::generateSlug($quote->name);
            }
        });
    }
    public function books()
    {
        return $this->morphedByMany(
            Book::class,
            'model',
            'model_quotes',
            'quote_id',
            'model_id'
        );
    }
    public function quoteImage()
    {
        return $this->belongsTo(QuoteImage::class);
    }
    public function quoteImages()
    {
        return $this->belongsToMany(
            QuoteImage::class,
            'quote_quote_image',
            'quote_id',
            'quote_image_id'
        )->select('quote_images.*');
    }
    public function syncQuoteImages($quoteImages)
    {
        if (is_null($quoteImages)) {
            $quoteImageIds = [];
        } elseif (is_array($quoteImages) || $quoteImages instanceof \Illuminate\Support\Collection) {
            $quoteImageIds = collect($quoteImages)
                ->map(function ($item) {
                    if (is_object($item) && isset($item->id)) {
                        return $item->id;
                    }
                    return $item;
                })
                ->filter(function ($id) {
                    return !empty($id) && is_numeric($id);
                })
                ->unique()
                ->values()
                ->all();
        } else {
            if (is_object($quoteImages) && isset($quoteImages->id)) {
                $id = $quoteImages->id;
            } else {
                $id = $quoteImages;
            }
            $quoteImageIds = (!empty($id) && is_numeric($id)) ? [$id] : [];
        }
        $this->quoteImages()->sync($quoteImageIds);
    }
    public function getQuoteImageIds(): Collection
    {
        return $this->quoteImages()->pluck('id');
    }
    public function book(): Attribute
    {
        return Attribute::get(fn() => $this->books()->first());
    }
    public function thumbnailFallbackUrl(): Attribute
    {
        $quoteImage = $this->quoteImage ?? $this->images->first();
        $url = $quoteImage ? $quoteImage->generatedImage($this, 'sm', 'webp') : asset('assets/images/quote.svg');
        return Attribute::get(fn() => $url);
    }
    public function downloadUrl(): Attribute
    {
        $quoteImage = $this->quoteImage ?? $this->images->first();
        $url = $quoteImage ? $this->getDownloadImageUrl($quoteImage) : null;
        return Attribute::get(fn() => $url);
    }
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
        // $this->addMediaCollection('images')->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png']);
    }
    public function images(): Attribute
    {
        return Attribute::get(function () {
            $images = collect();
            if ($this->quoteImage) {
                $images->push($this->quoteImage);
            }
            if ($this->quoteImages()->count()) {
                $images = $images->merge($this->quoteImages->whereNotIn('id', $images->pluck('id')->toArray()));
            }
            if ($images->count() < 5) {
                $images = $images->merge(QuoteImage::query()->category($this->getCategoryIds()->toArray())->whereNotIn('id', $images->pluck('id')->toArray())->take(5 - $images->count())->get());
            }
            if ($images->count() < 5) {
                $images = $images->merge(QuoteImage::all()->whereNotIn('id', $images->pluck('id')->toArray())->take(5 - $images->count()));
            }
            return $images->take(5);
        });
    }
    public function randomImages(): Attribute
    {
        return Attribute::get(function () {
            $images = collect();

            // صور عشوائية من نفس التصنيف
            $categoryImages = QuoteImage::query()
                ->inRandomOrder()
                ->category($this->getCategoryIds()->toArray())
                ->take(5)
                ->get();

            $images = $images->merge($categoryImages);

            // لو أقل من 5، كمّل من صور عامة
            if ($images->count() < 5) {
                $fallbackImages = QuoteImage::query()
                    ->inRandomOrder()
                    ->whereNotIn('id', $images->pluck('id'))
                    ->take(5 - $images->count())
                    ->get();

                $images = $images->merge($fallbackImages);
            }

            return $images->take(5);
        });
    }
    public function editUrl(): Attribute
    {
        return Attribute::get(fn() => $this->id && route_has('dashboard.quotes.edit') ? route('dashboard.quotes.edit', $this) : null);
    }
    public function slides(): Attribute
    {
        $quoteImages = QuoteImage::all();
        return Attribute::get(fn() => $quoteImages->map(fn(QuoteImage $quoteImage) => [
            'image' => $quoteImage->generatedImage($this),
            'button' => [
                'label' => __('Download'),
                'href' => $quoteImage->generatedImage($this),
            ],
        ]));
    }
    public function related()
    {
        // Number of items to return
        $count = (int) get_option('related_quotes_count', 5);

        // Determine strategy: category, tag, or author
        $strategy = get_option('related_quotes_query') ?: get_option('related_posts_query', 'category');

        $baseQuery = self::where('id', '!=', $this->id);
        $related = collect();

        switch ($strategy) {
            case 'tag':
                $related = self::query()->tag($this->getTagIds()->toArray())->where('id', '!=', $this->id)->get();
                break;

            case 'author':
                if ($this->author instanceof \App\Models\User) {
                    $related = self::query()->where('user_id', $this->author_id)->where('id', '!=', $this->id)->get();
                } elseif ($this->author instanceof \App\Models\Author) {
                    $related = self::query()->author($this->author_id)->where('id', '!=', $this->id)->get();
                }
                break;

            case 'category':
            default:
                $related = self::query()->category($this->getCategoryIds()->toArray())->where('id', '!=', $this->id)->get();
                break;
        }
        // Always ensure a full set: if less than required, fetch latest others
        if ($related->count() < $count) {
            $needed = $count - $related->count();
            $fallback = $baseQuery
                ->whereNotIn('id', $related->pluck('id')->toArray())
                ->latest()
                ->take($needed)
                ->get();

            $related = $related->merge($fallback);
        }

        // Deduplicate and limit
        return $related->unique('id')->take($count);
    }

    public function getDownloadImageUrl(QuoteImage $quoteImage, $size = 'full', $format = 'jpg')
    {
        return !empty($this->id) ? route('imgen.quote.download', ['quote' => $this, 'quote_image' => $quoteImage, 'size' => $size, 'format' => $format]) : null;
    }
    public function imagesResponse()
    {
        return $this->images->map(fn(QuoteImage $quoteImage) => [
            'source' => $quoteImage->generatedImage($this->id, 'md', 'webp'),
            'download' => route('imgen.quote.download', ['quote' => $this, 'quote_image' => $quoteImage, 'size' => 'full', 'format' => 'jpg']),
            'preview' => $quoteImage->preview_url,
        ])->toArray();
    }
    public function randomImagesResponse()
    {
        return $this->random_images->map(fn(QuoteImage $quoteImage) => [
            'source' => $quoteImage->generatedImage($this->id, 'md', 'webp'),
            'download' => route('imgen.quote.download', ['quote' => $this, 'quote_image' => $quoteImage, 'size' => 'full', 'format' => 'jpg']),
            'preview' => $quoteImage->preview_url,
        ])->toArray();
    }
}
