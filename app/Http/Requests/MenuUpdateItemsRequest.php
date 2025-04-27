<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuUpdateItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('manage_menus');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items'                        => ['nullable', 'array'],
            // Parent items
            'items.*.id'                   => [
                'required',
                'numeric',
                Rule::exists('menu_items', 'id')
                    ->where('menu_id', $this->menu),
            ],
            'items.*.name'                 => ['nullable', 'required_without:items.*.icon', 'string', 'max:255'],
            'items.*.icon'                 => ['nullable', 'required_without:items.*.name', 'string', 'max:255'],
            'items.*.class_name'           => ['nullable', 'string', 'max:255'],
            'items.*.type'                 => ['required', Rule::in(menu_item_types())],
            'items.*.page_id'              => [
                'nullable',
                'required_if:items.*.type,page',
                Rule::exists('posts', 'id')->where('type', 'page'),
            ],
            'items.*.post_id'              => [
                'nullable',
                'required_if:items.*.type,post',
                Rule::exists('posts', 'id')->where('type', 'post'),
            ],
            'items.*.category_id'          => [
                'nullable',
                'required_if:items.*.type,category',
                Rule::exists('categories', 'id')->where('type', 'category'),
            ],
            'items.*.url'                  => [
                'nullable',
                'required_if:items.*.type,custom',
                'regex:/^(#|hashtag|https?:\/\/)/',
            ],
            'items.*.navigate'             => ['boolean'],
            'items.*.new_tab'              => ['boolean'],

            // Nested children
            'items.*.children'             => ['nullable', 'array'],
            'items.*.children.*.id'        => [
                'required',
                'numeric',
                Rule::exists('menu_items', 'id')
                    ->where('menu_id', $this->menu),
            ],
            'items.*.children.*.name'      => ['nullable', 'required_without:items.*.children.*.icon', 'string', 'max:255'],
            'items.*.children.*.icon'      => ['nullable', 'required_without:items.*.children.*.name', 'string', 'max:255'],
            'items.*.children.*.class_name' => ['nullable', 'string', 'max:255'],
            'items.*.children.*.type'      => ['required', Rule::in(menu_item_types())],
            'items.*.children.*.page_id'   => [
                'nullable',
                'required_if:items.*.children.*.type,page',
                Rule::exists('posts', 'id')->where('type', 'page'),
            ],
            'items.*.children.*.post_id'   => [
                'nullable',
                'required_if:items.*.children.*.type,post',
                Rule::exists('posts', 'id')->where('type', 'post'),
            ],
            'items.*.children.*.category_id' => [
                'nullable',
                'required_if:items.*.children.*.type,category',
                Rule::exists('categories', 'id')->where('type', 'category'),
            ],
            'items.*.children.*.url'       => [
                'nullable',
                'required_if:items.*.children.*.type,custom',
                'regex:/^(#|hashtag|https?:\/\/)/',
            ],
            'items.*.children.*.navigate'  => ['boolean'],
            'items.*.children.*.new_tab'   => ['boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            //items
            'items.*.name.required_without'                  => __('Either name or icon is required.'),
            'items.*.icon.required_without'                  => __('Either name or icon is required.'),
            'items.*.page_id.required_if'                    => __('The selected page is invalid or missing.'),
            'items.*.post_id.required_if'                    => __('The selected post is invalid or missing.'),
            'items.*.category_id.required_if'                => __('The selected category is invalid or missing.'),
            'items.*.url.required_if'                        => __('A valid URL (or hashtag) is required for custom-type items.'),
            'items.*.url.regex'                              => __('The URL must start with #, hashtag, or http(s)://.'),
            'items.*.type.required'                          => __('Please select a valid type.'),
            'items.*.id.required'                            => __('Missing identifier for a menu item.'),
            'items.*.id.numeric'                             => __('Invalid identifier for a menu item.'),

            //children
            'items.*.children.*.name.required_without'       => __('Either name or icon is required.'),
            'items.*.children.*.icon.required_without'       => __('Either name or icon is required.'),
            'items.*.children.*.page_id.required_if'         => __('The selected page is invalid or missing.'),
            'items.*.children.*.post_id.required_if'         => __('The selected post is invalid or missing.'),
            'items.*.children.*.category_id.required_if'     => __('The selected category is invalid or missing.'),
            'items.*.children.*.url.required_if'             => __('A valid URL (or hashtag) is required for custom-type items.'),
            'items.*.children.*.url.regex'                   => __('The URL must start with #, hashtag, or http(s)://.'),
            'items.*.children.*.type.required'               => __('Please select a valid type.'),
            'items.*.children.*.id.required'                 => __('Missing identifier for a menu item.'),
            'items.*.children.*.id.numeric'                  => __('Invalid identifier for a menu item.'),
        ];
    }
    public function ruless(): array
    {
        return [
            'items' => ['nullable', 'array'],
            'items.*.id' => ['required', 'numeric', Rule::exists('menu_items', 'id')->where('menu_id', $this->menu)],
            'items.*.name' => ['nullable', 'required_without:items.*.icon', 'string', 'max:255'],
            'items.*.icon' => ['nullable', 'required_without:items.*.name', 'string', 'max:255'],
            'items.*.class_name' => ['nullable', 'string', 'max:255'],
            'items.*.type' => ['required', Rule::in(menu_item_types())],
            'items.*.page_id' => ['required_if:items.*.type,page', Rule::exists('posts', 'id')->where('type', 'page')],
            'items.*.post_id' => ['required_if:items.*.type,post', Rule::exists('posts', 'id')->where('type', 'post')],
            'items.*.category_id' => ['required_if:items.*.type,category', Rule::exists('categories', 'id')->where('type', 'category')],
            'items.*.url' => ['required_if:items.*.type,custom', 'regex:/^(#|hashtag|https?:\/\/)/'],
            'items.*.navigate' => ['boolean'],
            'items.*.new_tab' => ['boolean'],
            'items.*.children' => ['nullable', 'array'],
            'items.*.children.*.id' => ['required', 'numeric', Rule::exists('menu_items', 'id')->where('menu_id', $this->menu)],
            'items.*.children.*.name' => ['nullable', 'required_without:items.*.children.*.icon', 'string', 'max:255'],
            'items.*.children.*.icon' => ['nullable', 'required_without:items.*.children.*.name', 'string', 'max:255'],
            'items.*.children.*.class_name' => ['nullable', 'string', 'max:255'],
            'items.*.children.*.type' => ['required', Rule::in(menu_item_types())],
            'items.*.page_id' => ['required_if:items.*.children.*.type,page', Rule::exists('posts', 'id')->where('type', 'page')],
            'items.*.post_id' => ['required_if:items.*.children.*.type,post', Rule::exists('posts', 'id')->where('type', 'post')],
            'items.*.category_id' => ['required_if:items.*.children.*.type,category', Rule::exists('categories', 'id')->where('type', 'category')],
            'items.*.url' => ['required_if:items.*.children.*.type,custom', 'regex:/^(#|hashtag|https?:\/\/)/'],
            'items.*.children.*.navigate' => ['boolean'],
            'items.*.children.*.new_tab' => ['boolean'],
        ];
    }
}
