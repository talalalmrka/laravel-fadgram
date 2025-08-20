<?php

namespace App\Traits;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;

trait HasAuthor
{
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'model', 'model_author');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getAuthorAttribute()
    {
        return $this->authors()->first();
    }
    public function authorId(): Attribute
    {
        return Attribute::get(fn() => $this->author?->id);
    }
    public function authorName(): Attribute
    {
        return Attribute::get(fn() => $this->author?->name);
        /* return Attribute::get(fn() => match (true) {
            $this->author instanceof User => $this->author->display_name,
            $this->author instanceof Author => $this->author->name,
            default => null,
        }); */
    }
    public function authorPermalink(): Attribute
    {
        return Attribute::get(fn() => $this->author?->permalink);
    }
    public function getAuthorThumbnail($conversion = null)
    {
        return $this->author?->getThumbnailUrl($conversion);
        /* return match (true) {
            $this->author instanceof User => $this->author->getAvatarUrl($conversion),
            $this->author instanceof Author => $this->author->getThumbnailUrl($conversion),
            default => null,
        }; */
    }
    public function authorThumbnail(): Attribute
    {
        return Attribute::get(fn() => $this->getAuthorThumbnail('xs'));
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

    public function assignAuthor($author)
    {
        $id = $author instanceof Author ? $author->id : (int) $author;
        $this->authors()->sync([$id]);
    }
    public function removeAuthor()
    {
        $this->authors()->detach();
    }
    /**
     * Resolve author(s) to an array of IDs for handling author-related logic.
     *
     * @param  int|array|Author|\Illuminate\Support\Collection  $author
     * @return array
     */
    public function resolveAuthorId($author): array
    {
        if ($author instanceof Author) {
            return [$author->id];
        }
        if ($author instanceof \Illuminate\Support\Collection) {
            return $author->pluck('id')->all();
        }
        if (is_array($author)) {
            return array_map(function ($item) {
                return $item instanceof Author ? $item->id : (int) $item;
            }, $author);
        }
        return [(int) $author];
    }
    /**
     * Scope the model query to certain authors only.
     *
     * @param  Builder  $query
     * @param  int|array|Author|\Illuminate\Support\Collection  $authors
     * @param  bool  $without  Determine if the query should exclude these authors.
     * @return Builder
     */
    public function scopeAuthor(Builder $query, $authors, $without = false): Builder
    {
        $authorIds = $this->resolveAuthorId($authors);

        return $query->whereHas('authors', function ($query) use ($authorIds, $without) {
            if ($without) {
                $query->whereNotIn('authors.id', $authorIds);
            } else {
                $query->whereIn('authors.id', $authorIds);
            }
        });
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
