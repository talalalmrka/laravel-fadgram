<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasMeta;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasThumbnail;
use App\Traits\WithEditUrl;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasThumbnail, HasMeta, WithEditUrl, HasCategories, HasTags;
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
    ];
    protected static function booted()
    {
        static::addGlobalScope('post', function (Builder $builder) {
            $builder->where('type', 'post');
        });
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = self::generateSlug($post->name);
            }
        });

        static::updating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = self::generateSlug($post->name);
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getPermalinkAttribute()
    {
        return !empty($this->id) && Route::has('post') ? route('post', $this) : null;
    }
    public function getAuthorNameAttribute()
    {
        return $this->user?->name;
    }
    public function getDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }
    public function getThumbnailFallbackUrlAttribute()
    {
        return asset('assets/img/post-thumbnail.png');
    }
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
        $this->addMediaCollection('images')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ]);
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

    public function getLayout()
    {
        $template = $this->getMeta('template', 'cover');
        $layout = "layouts.$template";
        return view()->exists($layout) ? $layout : "layouts.app";
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function scopePublish($query)
    {
        return $query->where('status', 'publish');
    }
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
    public function scopeTrash($query)
    {
        return $query->where('status', 'trash');
    }
}
