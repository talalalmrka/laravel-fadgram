<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Spatie\Permission\Models\Role;

class ValidRoles implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value)) {
            $valid = Role::where('name', $value)->exists();
            if (!$valid) {
                $fail(__('The :attribute is not valid role name!', ['attribute' => $attribute]));
            }
        }
        if (is_numeric($value)) {
            $valid = Role::find($value);
            if (!$valid) {
                $fail(__('The :attribute is not valid role id!', ['attribute' => $attribute]));
            }
        }
        if (is_array($value)) {
            foreach ($value as $item) {
                if (is_string($item)) {
                    $valid = Role::where('name', $item)->exists();
                    if (!$valid) {
                        $fail(__('The :attribute has invalid role name ":name"!', ['attribute' => $attribute, 'name' => $item]));
                    }
                }
                if (is_numeric($item)) {
                    $valid = Role::find($item);
                    if (!$valid) {
                        $fail(__('The :attribute has invalid role id ":id"!', ['attribute' => $attribute, 'id' => $item]));
                    }
                }
            }
        }
    }
}
