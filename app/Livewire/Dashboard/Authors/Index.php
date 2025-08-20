<?php

namespace App\Livewire\Dashboard\Authors;

use App\Livewire\Components\Datatable\Datatable;
use App\Models\Author;
use App\Models\User;

class Index extends Datatable
{
    public function builder()
    {
        return Author::query();
    }
    public function getColumns()
    {
        return [
            column('name')
                ->label(__('Name'))
                ->sortable()
                ->content(function (Author $author) {
                    return thumbnail([
                        'title' => a([
                            'href' => $author->permalink,
                            'target' => '_blank',
                            'label' => $author->name,
                            'title' => $author->name,
                        ]),
                        'image' => $author?->getFirstMediaUrl('thumbnail'),
                    ]);
                }),
            column('status')
                ->label(__('Status'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center')
                ->content(function (Author $author) {
                    return status_badge($author->status);
                }),
            column('template')
                ->label(__('Template'))
                ->class('text-center')
                ->content(function (Author $author) {
                    return template_badge($author->template);
                }),
            column('quotes')
                ->label(__('Quotes'))
                ->sortable()
                ->content(function (Author $author) {
                    // return json_encode($author->quotes()->toArray());
                    return $author->quotes()->count();
                }),
        ];
    }
    public function render()
    {
        return view('livewire.dashboard.authors.index')->layout('layouts.dashboard', [
            'title' => __('Authors'),
        ]);
    }
}
