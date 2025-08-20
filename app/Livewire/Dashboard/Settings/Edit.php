<?php

namespace App\Livewire\Dashboard\Settings;

use App\Traits\WithEditModelDialog;
use Livewire\Component;
use App\Models\Setting;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

class Edit extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'setting';
    #[Locked]
    public Setting $setting;
    public $type = 'text';
    public $key = '';
    public $value = '';

    protected $fillable_data = ['type', 'key', 'value'];
    protected $fillable_media = [];
    public function mount(Setting $setting)
    {
        $this->authorize('manage_settings');
        $this->setting = $setting;
    }
    public function rules()
    {
        return [
            'type' => ['required', 'string', 'max:255', Rule::in(setting_types())],
            'key' => ['required', 'string', Rule::unique('settings', 'key')->ignore($this->setting->id)],
            'value' => match ($this->type) {
                'boolean' => ['required', 'boolean'],
                // 'json' => ['required', 'json'],
                default => ['required', 'string'],
            },
        ];
    }
}
