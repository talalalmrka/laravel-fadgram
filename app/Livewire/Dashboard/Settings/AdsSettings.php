<?php

namespace App\Livewire\Dashboard\Settings;

class AdsSettings extends SettingsPage
{
    public $ads_auto_enabled;
    public $ads_auto_code;
    public $ads_above_content_enabled;
    public $ads_above_content_code;
    public $ads_below_content_enabled;
    public $ads_below_content_code;
    public function title()
    {
        return __('Ads settings');
    }
    public function rules()
    {
        return [
            'ads_auto_enabled' => ['nullable', 'boolean'],
            'ads_auto_code' => ['nullable', 'string'],
            'ads_above_content_enabled' => ['nullable', 'boolean'],
            'ads_above_content_code' => ['nullable', 'string'],
            'ads_below_content_enabled' => ['nullable', 'boolean'],
            'ads_below_content_code' => ['nullable', 'string'],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.ads-settings');
    }
}
