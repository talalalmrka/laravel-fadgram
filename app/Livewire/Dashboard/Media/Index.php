<?php

namespace App\Livewire\Dashboard\Media;

use App\Livewire\Components\Datatable\Actions\Action;
use App\Livewire\Components\Datatable\Datatable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Index extends Datatable
{

    public $id_column = true;
    public function builder()
    {
        return Media::query();
    }

    public function getColumns()
    {
        return [
            column('preview')
                ->label(__('Preview'))
                ->content(function (Media $media) {
                    return view('livewire.dashboard.media.preview', ['media' => $media]);
                }),
            column('name')
                ->label(__('Details'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(function (Media $media) {
                    return view('livewire.dashboard.media.details', ['media' => $media]);
                }),
        ];
    }
    public function getActions()
    {
        return [
            Action::make('external')
                ->icon('bi-box-arrow-up-right')
                ->target('_blank')
                ->navigate(false)
                ->title(__('Open in new tab'))
                ->href(function (Media $media) {
                    return $media->original_url;
                }),
            Action::make('show')->icon('bi-eye-fill')->title(__('Details')),
            Action::make('download')->icon('bi-cloud-arrow-down'),
            Action::make('edit')->icon('bi-pencil-square'),
            Action::make('delete')->icon('bi-trash-fill'),
        ];
    }
    public function create()
    {
        $this->dispatch('create-media');
    }
    public function edit($id)
    {
        $this->authorize('manage_media', $id);
        $this->dispatch('edit', 'media', $id);
    }
    public function show($id)
    {
        $this->authorize('manage_media', $id);
        $this->dispatch('show', 'media', $id);
    }
    public function download(Media $media)
    {
        return response()->download($media->getPath(), $media->file_name);
    }
    public function render()
    {
        return view('livewire.dashboard.media.index')->layout('layouts.dashboard', [
            'title' => __('Media library'),
        ]);
    }
}
