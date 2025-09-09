<?php

namespace App\Livewire\Dashboard\Settings;

use Illuminate\Validation\Rule;
use Livewire\Component;

class ColorsSettings extends SettingsPage
{
    public $color_primary;
    public $color_secondary;
    public function title()
    {
        return __('Colors settings');
    }

    public function rules()
    {
        return [
            'color_primary' => ['nullable', 'string', Rule::in(colors())],
            'color_secondary' => ['nullable', 'string', Rule::in(colors())],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.colors-settings', [
            'colorOptions' => color_options([
                [
                    'label' => 'default',
                    'value' => ''
                ],
            ]),
        ]);
    }
}
