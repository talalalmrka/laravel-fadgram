<?php

namespace App\Livewire\Dashboard\Settings;

use App\Livewire\Components\Datatable\Datatable;
use App\Livewire\Components\Datatable\Columns\Column;
use App\Models\Setting;

class Index extends Datatable
{
    public $id_column = true;
    public function builder()
    {
        return Setting::query();
    }
    public function getColumns()
    {
        return [
            Column::make('type')
                ->label(__('Type'))
                ->sortable()
                ->searchable()
                ->filterable(),
            Column::make('key')
                ->label(__('Key'))
                ->sortable()
                ->searchable()
                ->filterable(),
            Column::make('value')
                ->label(__('Value'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(function (Setting $setting) {
                    return $this->valueContent($setting);
                    // return resolve_option_value($setting);
                }),
        ];
    }
    public function valueContent(Setting $setting)
    {
        if (is_array($setting->value) || is_object($setting->value)) {
            return json_encode($setting->value);
        }
        if (filter_var($setting->value, FILTER_VALIDATE_URL)) {
            return view('components.link', [
                'href' => $setting->value,
                'target' => '_blank',
            ]);
        }
        return $setting->value;
    }
    public function edit($id)
    {
        $this->dispatch('edit', 'setting', $id);
    }
    public function create()
    {
        $this->dispatch('edit', 'setting');
    }
    public function render()
    {
        return view('livewire.dashboard.settings.index')->layout('layouts.dashboard', [
            'title' => __('Settings'),
        ]);
    }
}
