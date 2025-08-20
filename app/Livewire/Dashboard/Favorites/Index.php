<?php

namespace App\Livewire\Dashboard\Favorites;

use App\Livewire\Components\Datatable\Datatable;
use App\Models\Favorite;
use Livewire\Component;

class Index extends Datatable
{
    public function builder()
    {
        return Favorite::query();
    }
    public function getColumns()
    {
        return [
            column('user_id')
                ->label(__('User'))
                ->sortable()
                ->content(fn(Favorite $favorite) => $favorite->user ? thumbnail([
                    'title' => a([
                        'href' => $favorite->user_permalink,
                        'target' => '_blank',
                        'label' => $favorite->user_name,
                    ]),
                    'image' => $favorite->user?->getThumbnailUrl('xs'),
                ]) : ''),
            column('session_id')
                ->label(__('Session id'))
                ->sortable(),
            column('model_type')
                ->label(__('Model'))
                ->sortable()
                ->content(fn(Favorite $favorite) => thumbnail([
                    'title' => a([
                        'href' => $favorite->model->permalink,
                        'target' => '_blank',
                        'label' => $favorite->model->name,
                    ]),
                    'image' => $favorite->model?->getThumbnailUrl('xs'),
                ])),
        ];
    }
    public function render()
    {
        return view('livewire.dashboard.favorites.index')->layout('layouts.dashboard', [
            'title' => __('Favorites'),
        ]);
    }
}
