<?php

namespace App\Traits;

trait HasNextPrev
{
    public function nextItem($in_same_category = false, $excluded_categories = '', $category_type = 'category')
    {
        $query = self::where('id', '>', $this->id)->orderBy('id', 'asc');

        if ($in_same_category && method_exists($this, 'getCategoryIds')) {
            $ids = $this->getCategoryIds()->toArray();
            if ($category_type === 'tag' && method_exists($this, 'getTagIds')) {
                $ids = $this->getTagIds()->toArray();
                $query = $query->tag($ids);
            } elseif ($category_type === 'author' && method_exists($this, 'authorId')) {
                $authorId = $this->authorId;
                if ($authorId) {
                    $query = $query->where('user_id', $authorId);
                }
            } else {
                $query = $query->category($ids);
            }
        }

        if (!empty($excluded_categories) && method_exists($this, 'resolveCategoryIds')) {
            $excluded = is_array($excluded_categories) ? $excluded_categories : explode(',', $excluded_categories);
            $excluded = array_filter($excluded);
            if (!empty($excluded)) {
                $excludedIds = $this->resolveCategoryIds($excluded);
                $query = $query->category($excludedIds, true);
            }
        }

        return $query->first();
    }

    public function prevItem($in_same_category = false, $excluded_categories = '', $category_type = 'category')
    {
        $query = self::where('id', '<', $this->id)->orderBy('id', 'desc');

        if ($in_same_category && method_exists($this, 'getCategoryIds')) {
            $ids = $this->getCategoryIds()->toArray();
            if ($category_type === 'tag' && method_exists($this, 'getTagIds')) {
                $ids = $this->getTagIds()->toArray();
                $query = $query->tag($ids);
            } elseif ($category_type === 'author' && method_exists($this, 'authorId')) {
                $authorId = $this->authorId;
                if ($authorId) {
                    $query = $query->where('user_id', $authorId);
                }
            } else {
                $query = $query->category($ids);
            }
        }

        if (!empty($excluded_categories) && method_exists($this, 'resolveCategoryIds')) {
            $excluded = is_array($excluded_categories) ? $excluded_categories : explode(',', $excluded_categories);
            $excluded = array_filter($excluded);
            if (!empty($excluded)) {
                $excludedIds = $this->resolveCategoryIds($excluded);
                $query = $query->category($excludedIds, true);
            }
        }

        return $query->first();
    }
    public function nextPrevEnabled()
    {
        return (bool) get_option(strtolower(class_basename($this)) . '_next_prev_enabled');
    }
    public function nextLabel()
    {
        return get_option(strtolower(class_basename($this)) . '_next_label');
    }
    public function prevLabel()
    {
        return get_option(strtolower(class_basename($this)) . '_prev_label');
    }
}
