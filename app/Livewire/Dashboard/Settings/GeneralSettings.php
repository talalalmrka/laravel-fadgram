<?php

namespace App\Livewire\Dashboard\Settings;

use App\Rules\ValidDateFormat;
use Illuminate\Validation\Rule;

class GeneralSettings extends SettingsPage
{
    public $name;
    public $description;
    public $url;
    public $logo;
    public $logo_light;
    public $logo_width;
    public $logo_height;
    public $logo_label_enabled;
    public $favicon;
    public $locale;
    public $timezone;
    public $date_format;
    public $maintenance;
    public $closed;
    public function title()
    {
        return __('General settings');
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'url' => ['required', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'logo_light' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'logo_width' => ['nullable', 'numeric'],
            'logo_height' => ['nullable', 'numeric'],
            'logo_label_enabled' => ['nullable', 'boolean'],
            'favicon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'locale' => ['required', 'string', Rule::in(locales())],
            'timezone' => ['required', 'string', Rule::in(timezones())],
            'date_format' => ['required', new ValidDateFormat()],
            'maintenance' => ['nullable', 'boolean'],
            'closed' => ['nullable', 'boolean'],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.general-settings');
    }
}
