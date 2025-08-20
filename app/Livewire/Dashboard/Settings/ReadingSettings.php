<?php

namespace App\Livewire\Dashboard\Settings;

use Illuminate\Validation\Rule;

class ReadingSettings extends SettingsPage
{
    public $front_type;
    public $front_page;
    public $posts_page;
    public $posts_per_page;
    public $disable_search_engines;
    public function title()
    {
        return __('Reading settings');
    }
    public function rules()
    {
        return [
            'front_type' => ['required', 'string', Rule::in(front_types())],
            'front_page' => [
                'nullable',
                'required_if:front_type,page',
                Rule::exists('posts', 'id')->where('type', 'page'),
            ],
            'posts_page' => [
                'nullable',
                'required_if:front_type,page',
                Rule::exists('posts', 'id')->where('type', 'page'),
            ],
            'posts_per_page' => ['required', 'numeric', 'min:5', 'max:50'],
            'disable_search_engines' => ['nullable', 'boolean'],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.reading-settings'/* , [
            'disabled' => $this->front_type !== 'page',
        ] */);
    }
}
