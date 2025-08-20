<?php

namespace App\Livewire\Dashboard\Fonts;

use App\Livewire\Components\Datatable\Datatable;
use App\Models\Font;

class Index extends Datatable
{
    public function builder()
    {
        return Font::query();
    }

    public function getColumns()
    {
        return [
            column('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('style')
                ->label(__('Style'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('weight')
                ->label(__('Weight'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('display')
                ->label(__('Display'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('enabled')
                ->label('Enabled')
                ->sortable()
                ->content(function (Font $font) {
                    return view('livewire.dashboard.fonts.enabled-cell', ['font' => $font]);
                }),
        ];
    }
    public function edit($id)
    {
        $this->dispatch('edit', 'font', $id);
    }
    public function create()
    {
        $this->dispatch('edit', 'font');
    }
    public function toggleFont($id, $enabled)
    {
        $font = Font::findOrFail($id);
        if ($font) {
            $font->enabled = (bool) $enabled;
            $save = $font->save();
            if ($save) {
                $this->toastSuccess(__('Saved.'));
            } else {
                $this->toastError(__('Failed!'));
            }
        } else {
            $this->toastError(__('Font with id :id not found!', ['id' => $id]));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.fonts.index')->layout('layouts.dashboard', [
            'title' => __('Fonts'),
        ]);
    }
}
