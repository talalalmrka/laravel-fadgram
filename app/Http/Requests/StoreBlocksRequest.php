<?php

namespace App\Http\Requests;

use App\Http\Controllers\PageBuilderController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBlocksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('manage_pages');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'blocks' => ['nullable', 'array'],
            'blocks.*' => ['required', 'array'],
            'blocks.*.type' => ['required', 'string', Rule::in(PageBuilderController::blockTypes())],
            'blocks.*.attributes' => ['nullable', 'array'],
            'blocks.*.children' => ['nullable', 'array'],
        ];
    }
    public function ruless(): array
    {
        $rules = [];
        // dd($this->get('blocks'));
        foreach ($this->get('blocks') as $i => $block) {
            $rules["blocks.$i"] = ['required', 'array'];
            $rules["blocks.$i.type"] = ['required', 'string', Rule::in(PageBuilderController::blockTypes())];
            $blockRules = PageBuilderController::blockRules($block['type']);
            foreach ($blockRules as $k => $v) {
                $rules["blocks.$i.$k"] = $v;
            }
            /* $rules["blocks.$i"] = array_merge([
                'type' => ['required', 'string', Rule::in(PageBuilderController::blockTypes())],
            ], PageBuilderController::blockRules($block['type'])); */
        }
        // dd($rules);
        return $rules;
    }
}
