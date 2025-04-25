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
            'items' => ['nullable', 'array'],
            'items.*.id' => ['required', 'numeric', Rule::exists('menu_items', 'id')->where('menu_id', $this->menu)],
            'items.*.name' => ['nullable', 'required_without:icon', 'string', 'max:255'],
            'items.*.icon' => ['nullable', 'required_without:name', 'string', 'max:255'],
            'items.*.class_name' => ['nullable', 'string', 'max:255'],
            'items.*.type' => ['required', Rule::in(menu_item_types())],
            'items.*.navigate' => ['boolean'],
            'items.*.new_tab' => ['boolean'],
            'items.*.children' => ['nullable', 'array'],
            'items.*.children.*.id' => ['required', 'numeric', Rule::exists('menu_items', 'id')->where('menu_id', $this->menu)],
            'items.*.children.*.name' => ['nullable', 'required_without:icon', 'string', 'max:255'],
            'items.*.children.*.icon' => ['nullable', 'required_without:name', 'string', 'max:255'],
            'items.*.children.*.class_name' => ['nullable', 'string', 'max:255'],
            'items.*.children.*.type' => ['required', Rule::in(menu_item_types())],
            'items.*.children.*.navigate' => ['boolean'],
            'items.*.children.*.new_tab' => ['boolean'],
        ];
    }
}
