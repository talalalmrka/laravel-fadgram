<?php

use Spatie\Permission\Models\Permission;

if (!function_exists('permission_options')) {
    function permission_options($guard_name = 'web')
    {
        $permissions = Permission::where('guard_name', $guard_name)->get();
        return $permissions->map(function (Permission $permission) {
            return [
                'value' => $permission->name,
                'label' => $permission->name,
            ];
        })->toArray();
    }
}

if (!function_exists('can')) {
    function can($permission)
    {
        return auth()->check() && auth()->user()->can($permission);
    }
}
