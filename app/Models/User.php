<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasMeta;
use App\Traits\HasThumbnail;
use App\Traits\WithPermalink;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        Notifiable,
        HasApiTokens,
        HasRoles,
        InteractsWithMedia,
        HasMeta,
        HasThumbnail;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $appends = [
        'display_name',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $firstUser = DB::table('users')->orderBy('id')->first();

            if ($firstUser) {
                // Transfer posts to the first user before deleting
                \App\Models\Post::where('user_id', $user->id)->update(['user_id' => $firstUser->id]);
            }
        });
    }
    public function displayName(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('display_name', $this->name));
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function approvedComments()
    {
        return $this->comments()->where('approved', true);
    }
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
    public function publishedQuotes()
    {
        return $this->quotes()->where('status', 'publish');
    }
    public function permalink(): Attribute
    {
        return Attribute::get(fn() => route_has('user') ? route('user', $this) : null);
    }
    public function about(): Attribute
    {
        return Attribute::get(fn() => $this->getMeta('about'));
    }
    public function registerMediaCollections(): void
    {
        $this->registerThumbnail();
        /*$this
            ->addMediaCollection('avatar')
            ->useFallbackUrl(asset('assets/img/profile.svg'))
            ->useFallbackPath(public_path('/assets/img/profile.svg'))
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ]);*/
        $this
            ->addMediaCollection('images')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ]);
        $this
            ->addMediaCollection('croppedimage')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ]);
        $this
            ->addMediaCollection('files');
    }
    public function getThumbnailFallbackUrlAttribute()
    {
        return asset('assets/images/profile.svg');
    }
    public function getAvatarUrl($conversionName = null): string
    {
        $conversionName = $conversionName ?? '';
        return $this->getFirstMediaUrl('avatar', $conversionName);
    }
    public function getAvatarUrlAttribute(): string
    {
        return $this->getAvatarUrl('sm');
    }

    /* public function getDisplayNameAttribute()
    {
        return $this->getMeta('display_name', $this->name);
    } */
}
