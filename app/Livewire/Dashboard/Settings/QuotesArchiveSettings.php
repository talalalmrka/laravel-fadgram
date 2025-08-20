<?php

namespace App\Livewire\Dashboard\Settings;

use Livewire\Component;

class QuotesArchiveSettings extends SettingsPage
{
    public function title()
    {
        return __('Quote');
    }
    public function view()
    {
        return view('livewire.dashboard.settings.quotes-archive-settings');
    }
}
