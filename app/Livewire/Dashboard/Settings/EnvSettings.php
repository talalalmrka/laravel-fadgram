<?php

namespace App\Livewire\Dashboard\Settings;

use App\Traits\WithToast;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;

class EnvSettings extends Component
{
    use WithToast;
    public $path;
    public $env = '';
    public function mount()
    {
        $this->path = base_path('.env');
        if (File::exists($this->path)) {
            $this->env = file_get_contents($this->path);
        }
    }
    public function rules()
    {
        return [
            'env' => ['nullable', 'string'],
        ];
    }
    /* public function loadEnvArray()
    {
        $this->env_array = [];
        $path = base_path('.env');
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments and malformed lines
            if (Str::startsWith($line, '#') || ! Str::contains($line, '=')) {
                continue;
            }

            [$key, $rest] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($rest, "\"' ");

            $this->env_array[$key] = $value;
        }
    } */
    public function save()
    {
        $this->validate();
        $save = File::put($this->path, $this->env);
        if ($save) {
            $this->status(__('Saved successfully'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.settings.env-settings')->layout('layouts.dashboard', [
            'title' => __('Environment settings')
        ]);
    }
}
