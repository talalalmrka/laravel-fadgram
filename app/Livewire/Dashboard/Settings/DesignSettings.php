<?php

namespace App\Livewire\Dashboard\Settings;


class DesignSettings extends SettingsPage
{
    public $header_code_enabled;
    public $header_code;
    public $backtop_enabled;
    public $footer_copyrights;
    public $footer_code_enabled;
    public $footer_code;
    public $custom_css_enabled;
    public $custom_css;
    public $custom_js_enabled;
    public $custom_js;
    public $eruda_enabled;

    public function title()
    {
        return __('Design settings');
    }
    public function rules()
    {
        return [
            'header_code_enabled' => ['nullable', 'boolean'],
            'header_code' => ['nullable', 'string'],
            'backtop_enabled' => ['nullable', 'boolean'],
            'footer_copyrights' => ['nullable', 'string'],
            'footer_code_enabled' => ['nullable', 'boolean'],
            'footer_code' => ['nullable', 'string'],
            'custom_css_enabled' => ['nullable', 'boolean'],
            'custom_css' => ['nullable', 'string'],
            'custom_js_enabled' => ['nullable', 'boolean'],
            'custom_js' => ['nullable', 'string'],
            'eruda_enabled' => ['nullable', 'boolean'],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.design-settings');
    }
}
