<?php

namespace App\Livewire\Dashboard\Settings;

use App\Models\Setting;
use App\Traits\HasMediaProperties;
use App\Traits\WithToast;
use Database\Seeders\SettingSeeder;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

abstract class SettingsPage extends Component
{
    use WithToast, HasMediaProperties;
    public function mount()
    {
        $this->authorize('manage_settings');
        if (method_exists($this, 'beforeMount')) {
            $this->beforeMount();
        }
        $this->fillSettings();
        if (method_exists($this, 'afterMount')) {
            $this->afterMount();
        }
    }
    public function fillSettings()
    {
        foreach ($this->all() as $key => $value) {
            $this->{$key} = get_option($key, get_default_option($key));
        }
    }
    public function updated($property, $value)
    {
        $this->validateOnly($property);
    }
    #[Computed]
    public function getPreviews($key)
    {
        $setting = Setting::withKey($key);
        return $setting ? $setting->getPreviews($this->{$key}) : [];
    }
    public function save()
    {
        $this->authorize('manage_settings');
        if (method_exists($this, 'beforeSave')) {
            $this->beforeSave();
        }
        $validated = $this->validate();
        foreach ($validated as $key => $value) {
            $type = get_option_type($key);
            $save = update_option($key, $value, $type);
            if ($save) {
                if ($type === 'file') {
                    $this->reset($key);
                }
            } else {
                $this->addError($key, __('Save failed!'));
            }
        }
        $this->status(__('Saved.'));
        if (method_exists($this, 'afterSave')) {
            $this->afterSave();
        }
    }
    public function resetSettings()
    {
        $this->authorize('manage_settings');
        try {
            DB::table('settings')->truncate();
            Artisan::call('db:seed', [
                '--class' => \Database\Seeders\SettingSeeder::class,
                '--force' => true,            // run in production
            ]);
            $this->skipRender();
            $this->addSuccess('reset', __('Settings reseted.'));

            $this->js('refresh');
        } catch (Exception $e) {
            $this->addError('reset', $e->getMessage());
        }
    }
    abstract public function title();
    abstract public function view();
    public function render()
    {
        return $this->view()->layout('layouts.dashboard', [
            'title' => $this->title(),
        ]);
    }
}
