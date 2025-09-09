<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

trait HasUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userName(): Attribute
    {
        return Attribute::get(fn() => $this->user?->display_name);
    }
    public function userPermalink(): Attribute
    {
        return Attribute::get(fn() => $this->user?->permalink);
    }
    public function userThumbnailUrl(): Attribute
    {
        return Attribute::get(fn() => $this->user?->getThumbnailUrl('xs'));
    }
    public function resolveUserId($user): array
    {
        if ($user instanceof User) {
            return [$user->id];
        }
        if ($user instanceof \Illuminate\Support\Collection) {
            return $user->pluck('id')->all();
        }
        if (is_array($user)) {
            return array_map(function ($item) {
                return $item instanceof User ? $item->id : (int) $item;
            }, $user);
        }
        return [(int) $user];
    }
    /**
     * Scope the model query to certain users only.
     *
     * @param  Builder  $query
     * @param  int|array|User|\Illuminate\Support\Collection  $users
     * @param  bool  $without  Determine if the query should exclude these authors.
     * @return Builder
     */
    public function scopeWithUser(Builder $query, $users, $without = false): Builder
    {
        $userIds = $this->resolveUserId($users);

        if ($without) {
            return $query->whereNotIn('user_id', $userIds);
        } else {
            return $query->whereIn('user_id', $userIds);
        }
    }
}
