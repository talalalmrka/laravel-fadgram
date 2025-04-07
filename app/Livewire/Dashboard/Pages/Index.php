<?php

namespace App\Livewire\Dashboard\Pages;

use App\Livewire\Components\Datatable\Actions\Action;
use App\Livewire\Components\Datatable\Datatable;
use App\Livewire\Components\Datatable\Columns\Column;
use App\Models\Page;

class Index extends Datatable
{
    public $id_column = true;
    public function builder()
    {
        return Page::query();
    }
    public function getColumns()
    {
        return [

            Column::make('user_id')
                ->label(__('Author'))
                ->sortable()
                ->content(function (Page $page) {
                    return thumbnail([
                        'title' => $page->user?->display_name,
                        'image' => $page->user?->getFirstMediaUrl('avatar'),
                    ]);
                }),
            Column::make('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable(),
            Column::make('slug')
                ->label(__('Slug'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center'),
            Column::make('status')
                ->label(__('Status'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center')
                ->content(function (Page $page) {
                    return badge(['label' => $page->status]);
                }),
        ];
    }
    public function getActions()
    {
        return [
            Action::make('edit')
                ->icon('bi-pencil-square')
                ->title(__('Edit'))
                ->target('_blank')
                ->href(function (Page $page) {
                    return route('dashboard.pages.edit', $page);
                }),
            Action::make('delete')->icon('bi-trash')->title(__('Delete')),
        ];
    }
    public function create()
    {
        $this->authorize('manage_pages');
        if (route_has('dashboard.pages.create')) {
            $this->redirect(route('dashboard.pages.create'), true);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.pages.index')->layout('layouts.dashboard', [
            'title' => __('Pages'),
        ]);
    }
}
