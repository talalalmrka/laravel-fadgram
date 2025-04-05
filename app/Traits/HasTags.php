<?php

namespace App\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    /**
     * Relationship with the tag model.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'model', 'model_tag');
    }

    /**
     * Scope the model query to certain tags only.
     *
     * @param  Builder  $query
     * @param  string|int|array|Category|Collection  $tags
     * @param  bool  $without  Determine if the query should exclude these tags.
     * @return Builder
     */
    public function scopeTag(Builder $query, $tags, $without = false): Builder
    {
        $tagIds = $this->resolveTagIds($tags);

        return $query->whereHas('tags', function ($query) use ($tagIds, $without) {
            if ($without) {
                $query->whereNotIn('tags.id', $tagIds);
            } else {
                $query->whereIn('tags.id', $tagIds);
            }
        });
    }

    /**
     * Assign the given tags to the model.
     *
     * @param  string|int|array|Category|Collection  ...$tags
     * @return $this
     */
    public function assignTag(...$tags)
    {
        $tagIds = $this->resolveTagIds($tags);
        $this->tags()->syncWithoutDetaching($tagIds);

        return $this;
    }

    /**
     * Revoke the given tag from the model.
     *
     * @param  string|int|Category  $tag
     * @return $this
     */
    public function removeTag($tag)
    {
        $tagId = $this->resolveTagId($tag);
        if ($tagId) {
            $this->tags()->detach($tagId);
        }

        return $this;
    }

    /**
     * Sync the given tags, removing any that are not in the list.
     *
     * @param  string|int|array|Category|Collection  ...$tags
     * @return $this
     */
    public function syncTags(...$tags)
    {
        $tagIds = $this->resolveTagIds($tags);
        $this->tags()->sync($tagIds);

        return $this;
    }

    /**
     * Determine if the model has (one of) the given tags.
     *
     * @param  string|int|Category  $tag
     * @return bool
     */
    public function hasTag($tag): bool
    {
        $tagId = $this->resolveTagId($tag);

        return $tagId ? $this->tags->contains('id', $tag) : false;
    }

    /**
     * Determine if the model has any of the given tags.
     *
     * @param  array|Collection  $tags
     * @return bool
     */
    public function hasAnytag(...$tags): bool
    {
        foreach ($tags as $tag) {
            if ($this->hasTag($tag)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the model has all of the given tags.
     *
     * @param  array|Collection  $tags
     * @return bool
     */
    public function hasAlltags($tags): bool
    {
        foreach ($tags as $tag) {
            if (!$this->hasTag($tag)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the names of all assigned tags.
     *
     * @return Collection
     */
    public function getTagNames(): Collection
    {
        return $this->tags->pluck('name');
    }

    /**
     * Get the slugs of the tags assigned to the model.
     */
    public function getTagSlugs(): Collection
    {
        return $this->tags->pluck('slug');
    }

    /**
     * Get the ids of the tags assigned to the model.
     */
    public function getTagIds(): Collection
    {
        return $this->tags->pluck('id');
    }

    /**
     * Resolve tag(s) to IDs for handling tag-related logic.
     *
     * @param  string|int|array|Category|Collection  $tags
     * @return array
     */
    public function resolveTagIds($tags): array
    {
        if ($tags instanceof Collection) {
            return $tags->pluck('id')->all();
        }

        if ($tags instanceof Category) {
            return [$tags->id];
        }

        if (is_array($tags)) {
            $tags = array_filter(Arr::flatten($tags));
            return Category::whereIn('slug', $tags)
                ->orWhereIn('id', $tags)
                ->pluck('id')
                ->all();
        }

        return [Category::where('slug', $tags)->orWhere('id', $tags)->value('id')];
    }

    /**
     * Resolve a single tag to its ID.
     *
     * @param  string|int|Category  $tag
     * @return int|null
     */
    protected function resolveTagId($tag): ?int
    {
        if ($tag instanceof Category) {
            return $tag->id;
        }

        if (is_numeric($tag)) {
            return $tag;
        }

        return Category::where('slug', $tag)->value('id');
    }
}
