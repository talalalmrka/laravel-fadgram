<?php

use App\Models\Post;

if (!function_exists('post')) {
    function post($id)
    {
        return Post::find($id);
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
