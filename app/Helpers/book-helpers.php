<?php

use App\Models\Book;

if (!function_exists('instance_book')) {
    function instance_book($object)
    {
        return $object instanceof Book;
    }
}

if (!function_exists('get_books')) {
    function get_books($options = [])
    {
        $ops = collect($options);
        $query = Book::where('status', 'publish');

        // categories
        $categories = $ops->get('categories');
        if ($categories && !empty($categories)) {
            $query->category($categories);
        }

        // categories
        $tags = $ops->get('tags');
        if ($tags && !empty($tags)) {
            $query->tag($tags);
        }

        // users
        $users = $ops->get('users');
        if ($users && !empty($users)) {
            $query->withUser($users);
        }

        // authors
        $authors = $ops->get('authors');
        if ($authors && !empty($authors)) {
            $query->author($authors);
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
            return $query->take($limit)->get();
        }

        $per_page = $ops->get('per_page', get_option('posts_per_page', 10));
        return $query->paginate($per_page);
    }
}
