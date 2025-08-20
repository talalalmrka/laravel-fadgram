<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait WithExcerpt
{
    public function getExcerpt($limit = 160, $end = '...', $preserveWords = false)
    {
        $excerpt = $this->getMeta('excerpt');
        if (!empty($excerpt)) {
            return $excerpt;
        }
        // Fallback: generate excerpt from content
        $content = strip_tags($this->content ?? '');
        $excerpt = Str::limit($content, $limit, $end, $preserveWords);
        return $excerpt;
    }
    public function excerpt(): Attribute
    {
        $length = get_option('excerpt_length', 139);
        $more = get_option('excerpt_more', '...');
        $preserveWords = (bool) get_option('excerpt_preverse_words', false);
        return Attribute::get(fn() => $this->getExcerpt($length, $more, $preserveWords));
    }
}
