<?php

namespace App\Traits;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;

trait HasAuthor
{
    use HasUser;
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'model', 'model_author');
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
    }
    public function authorPermalink(): Attribute
    {
        return Attribute::get(fn() => $this->author?->permalink);
    }
    public function getAuthorThumbnail($conversion = null)
    {
        return $this->author?->getThumbnailUrl($conversion);
    }
    public function authorThumbnail(): Attribute
    {
        return Attribute::get(fn() => $this->getAuthorThumbnail('xs'));
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
}
