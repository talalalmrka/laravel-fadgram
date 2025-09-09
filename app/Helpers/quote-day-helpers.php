<?php

use App\Models\QuoteDay;
use Carbon\Carbon;

if (!function_exists('instance_quote')) {
    function instance_quote($object)
    {
        return $object instanceof QuoteDay;
    }
}

if (!function_exists('get_quotes_for_day')) {
    function get_quotes_for_day($options = [])
    {
        $ops = collect($options);
        $day = $ops->get('day', Carbon::today());
        $query = QuoteDay::forDay($day);

        // categories
        $categories = $ops->get('categories');
        if ($categories && !empty($categories)) {
            $query->category($categories);
        }

        $sort = $ops->get('sort');
        if ($sort) {
            $field = sort_field($sort);
            $direction = sort_direction($sort);

            if ($field && $direction) {
                $query->orderBy($field, $direction);
            }
        }

        $limit = $ops->get('limit');
        if ($limit && !empty($limit)) {
            return $query->take($limit)->get()->map(fn(QuoteDay $quoteDay) => $quoteDay->quote);
        }

        $per_page = $ops->get('per_page', get_option('posts_per_page', 10));
        return $query->paginate($per_page)->map(fn(QuoteDay $quoteDay) => $quoteDay->quote);
    }
}
