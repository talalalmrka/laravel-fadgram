<?php

namespace App\Livewire\Dashboard\Settings;

class PermalinkSettings extends SettingsPage
{
    public $permalink_structure;
    public $category_base;
    public $tag_base;
    public function title()
    {
        return __('Permalink settings');
    }
    public function view()
    {
        return view('livewire.dashboard.settings.permalink-settings');
    }
}
