<?php

use App\Models\User;

if (!function_exists('instance_user')) {
    function instance_user($object)
    {
        return $object instanceof User;
    }
}
if (!function_exists('user_options')) {
    function user_options($options = [])
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
            $emptyOptionLabel = data_get($options, 'emptyOptionLabel', __('Select User'));
            $items->push([
                'label' => $emptyOptionLabel,
                'value' => '',
            ]);
        }
        $selected = data_get($options, 'selected');
        if ($selected) {
            if ($selected instanceof User) {
                $items->push([
                    'label' => $selected->display_name,
                    'value' => $selected->id,
                ]);
            } elseif (is_array($selected)) {
                foreach ($selected as $id) {
                    $user = User::find($id);
                    if ($user) {
                        $items->push([
                            'label' => $user->display_name,
                            'value' => $user->id,
                        ]);
                    }
                }
            } else {
                $user = User::find($selected);
                if ($user) {
                    $items->push([
                        'label' => $user->display_name,
                        'value' => $user->id,
                    ]);
                }
            }
        }
        $query = User::orderBy('id', 'desc');
        $search = data_get($options, 'search');
        if ($search) {
            // $query->where('name', 'like', "%{$search}%");
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('metas', function ($uq) use ($search) {
                        $uq->where('value', 'like', "%{$search}%");
                    });
            });
        }
        $limit = data_get($options, 'limit');
        $query->limit($limit);
        $users = $query->get();
        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $items->push([
                    'label' => $user->display_name,
                    'value' => $user->id,
                ]);
            }
        }
        // $items = $search ? $items->sortBy('label') : $items->sortByDesc('value');
        return $items->toArray();
    }
}

if (!function_exists('current_user')) {
    function current_user()
    {
        return auth()->user();
    }
}

if (!function_exists('current_user_id')) {
    function current_user_id()
    {
        return current_user()?->id;
    }
}
if (!function_exists('logged_in')) {
    function logged_in()
    {
        return auth()->check();
    }
}

if (!function_exists('is_user')) {
    function is_user($value)
    {
        return $value instanceof User;
    }
}
