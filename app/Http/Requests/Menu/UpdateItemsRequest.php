<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('manage_menus');
    }

    public function rules(): array
    {
        $rules = [
            'items' => ['nullable', 'array'],
        ];

        // Add rules for parent items and nested children up to 5 levels deep
        $rules += $this->generateMenuItemRules('items.*', 5);

        return $rules;
    }

    protected function generateMenuItemRules(string $path, int $depth): array
    {
        $rules = [];

        // Current level rules
        $rules["{$path}.id"] = [
            'required',
            'numeric',
            Rule::exists('menu_items', 'id')->where('menu_id', $this->menu),
        ];
        $rules["{$path}.name"] = ['nullable', 'required_without:' . $path . '.icon', 'string', 'max:255'];
        $rules["{$path}.icon"] = ['nullable', 'required_without:' . $path . '.name', 'string', 'max:255'];
        $rules["{$path}.class_name"] = ['nullable', 'string', 'max:255'];
        $rules["{$path}.type"] = ['required', Rule::in(menu_item_types())];
        $rules["{$path}.page_id"] = [
            'nullable',
            'required_if:' . $path . '.type,page',
            Rule::exists('posts', 'id')->where('type', 'page'),
        ];
        $rules["{$path}.post_id"] = [
            'nullable',
            'required_if:' . $path . '.type,post',
            Rule::exists('posts', 'id')->where('type', 'post'),
        ];
        $rules["{$path}.category_id"] = [
            'nullable',
            'required_if:' . $path . '.type,category',
            Rule::exists('categories', 'id')->where('type', 'category'),
        ];
        $rules["{$path}.url"] = [
            'nullable',
            'required_if:' . $path . '.type,custom',
            'regex:/^(#|hashtag|https?:\/\/)/',
        ];
        $rules["{$path}.navigate"] = ['boolean'];
        $rules["{$path}.new_tab"] = ['boolean'];
        $rules["{$path}.children"] = ['nullable', 'array'];

        // Recursively add rules for children if depth allows
        if ($depth > 0) {
            $childPath = "{$path}.children.*";
            $childRules = $this->generateMenuItemRules($childPath, $depth - 1);
            $rules = array_merge($rules, $childRules);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // Parent items
            'items.*.name.required_without' => __('Either name or icon is required.'),
            'items.*.icon.required_without' => __('Either name or icon is required.'),
            'items.*.page_id.required_if' => __('The selected page is invalid or missing.'),
            'items.*.post_id.required_if' => __('The selected post is invalid or missing.'),
            'items.*.category_id.required_if' => __('The selected category is invalid or missing.'),
            'items.*.url.required_if' => __('A valid URL (or hashtag) is required for custom-type items.'),
            'items.*.url.regex' => __('The URL must start with #, hashtag, or http(s)://.'),
            'items.*.type.required' => __('Please select a valid type.'),
            'items.*.id.required' => __('Missing identifier for a menu item.'),
            'items.*.id.numeric' => __('Invalid identifier for a menu item.'),

            // Nested children (applies to all levels due to recursive rules)
            'items.*.children.*.name.required_without' => __('Either name or icon is required.'),
            'items.*.children.*.icon.required_without' => __('Either name or icon is required.'),
            'items.*.children.*.page_id.required_if' => __('The selected page is invalid or missing.'),
            'items.*.children.*.post_id.required_if' => __('The selected post is invalid or missing.'),
            'items.*.children.*.category_id.required_if' => __('The selected category is invalid or missing.'),
            'items.*.children.*.url.required_if' => __('A valid URL (or hashtag) is required for custom-type items.'),
            'items.*.children.*.url.regex' => __('The URL must start with #, hashtag, or http(s)://.'),
            'items.*.children.*.type.required' => __('Please select a valid type.'),
            'items.*.children.*.id.required' => __('Missing identifier for a menu item.'),
            'items.*.children.*.id.numeric' => __('Invalid identifier for a menu item.'),
        ];
    }
}
