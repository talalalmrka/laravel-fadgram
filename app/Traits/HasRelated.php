<?php

namespace App\Traits;

use App\Models\Author;
use App\Models\User;

trait HasRelated
{
    public function related()
    {
        $table = $this->getTable();
        $related_count = get_option("related_{$table}_count", get_option('related_posts_count', 5));
        $related_query = get_option("related_{$table}_query", get_option('related_posts_query', 'category'));
        // Return related posts based on similar category, tag, or author if found
        $query = self::where('id', '!=', $this->id);
        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($related_query === 'category') {
            $query->category($this->getCategoryIds()->toArray());
        } elseif ($related_query === 'tag') {
            $query->tag($this->getTagIds()->toArray());
        } elseif ($related_query === 'author') {
            if ($this->author instanceof User) {
                $query->where('user_id', $this->author_id);
            } elseif ($this->author instanceof Author) {
                $query->author($this->author_id);
            }
        } else {
            $query->inRandomOrder();
        }
        return $query->latest()->take($related_count)->get();
        /* // Try to match by category if available
        if (isset($this->category_id) && $this->category_id) {
            $query->where('category_id', $this->category_id);
        }
        // If no category, try to match by tag if available
        elseif (method_exists($this, 'tags') && $this->tags()->count() > 0) {
            $tagIds = $this->tags()->pluck('id');
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('id', $tagIds);
            });
        }
        // If no category or tag, try to match by author/user if available
        elseif (isset($this->user_id) && $this->user_id) {
            $query->where('user_id', $this->user_id);
        }
        return $query->latest()->take(get_option('related_posts_count', 5))->get(); */
    }
}
