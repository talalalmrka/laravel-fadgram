<?php

use App\Models\Post;

if (!function_exists('post')) {
    function post($id)
    {
        return Post::find($id);
    }
}
if (!function_exists('instance_post')) {
    function instance_post($object)
    {
        return $object instanceof Post;
    }
}
if (!function_exists('post_options')) {
    function post_options($emptyOption = null)
    {
        $options = collect([]);
        if ($emptyOption) {
            $options->push([
                'label' => $emptyOption,
                'value' => '',
            ]);
        }
        $posts = Post::all();
        if ($posts->isNotEmpty()) {
            foreach ($posts as $post) {
                $options->push([
                    'label' => $post->name,
                    'value' => $post->id,
                ]);
            }
        }
        return $options->toArray();
    }
}

if (!function_exists('get_posts')) {
    function get_posts($options = [])
    {
        $ops = collect($options);
        $query = Post::where('status', 'publish')->where('type', 'post');

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
