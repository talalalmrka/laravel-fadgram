<?php

use App\Models\Author;

if (!function_exists('author')) {
    function author($id)
    {
        return Author::find($id);
    }
}
if (!function_exists('instance_author')) {
    function instance_author($object)
    {
        return $object instanceof Author;
    }
}
if (!function_exists('author_options')) {
    function author_options(array $options = [])
    {
        $default = [
            'selected' => null,
            'emptyOption' => false,
            'emptyOptionLabel' => false,
            'search' => null,
            'limit' => 5,
        ];
        $options = array_merge($default, $options);
        $items = collect([]);
        $emptyOption = (bool) data_get($options, 'emptyOption', false);
        if ($emptyOption) {
            $emptyOptionLabel = data_get($options, 'emptyOptionLabel', __('Select Author'));
            $items->push([
                'label' => $emptyOptionLabel,
                'value' => '',
            ]);
        }
        $selected = data_get($options, 'selected');
        if ($selected) {
            if ($selected instanceof Author) {
                $items->push([
                    'label' => $selected->name,
                    'value' => $selected->id,
                ]);
            } elseif (is_array($selected)) {
                foreach ($selected as $id) {
                    $author = Author::find($id);
                    if ($author) {
                        $items->push([
                            'label' => $author->name,
                            'value' => $author->id,
                        ]);
                    }
                }
            } else {
                $author = Author::find($selected);
                if ($author) {
                    $items->push([
                        'label' => $author->name,
                        'value' => $author->id,
                    ]);
                }
            }
        }
        $query = Author::orderBy('id', 'desc');
        $search = data_get($options, 'search');
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $limit = data_get($options, 'limit');
        $query->limit($limit);
        $authors = $query->get();
        if ($authors->isNotEmpty()) {
            foreach ($authors as $author) {
                $items->push([
                    'label' => $author->name,
                    'value' => $author->id,
                ]);
            }
        }
        // $items = $search ? $items->sortBy('label') : $items->sortByDesc('value');
        return $items->toArray();
    }
}

if (!function_exists('get_authors')) {
    function get_authors($options = [])
    {
        $ops = collect($options);
        $query = Author::where('status', 'publish');

        // categories
        $categories = $ops->get('categories');
        if ($categories && !empty($categories)) {
            $query->category($categories);
        }

        // tags
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
