<?php

namespace App\Livewire\Dashboard\Cache;

use App\Livewire\Components\Datatable\Buttons\Button;
use App\Livewire\Components\Datatable\Datatable;
use App\Models\CacheItem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Datatable
{
    public $id_column = false;
    public $created_at_column = false;
    public function builder()
    {
        return CacheItem::query();
    }

    public function getColumns()
    {
        return [
            column('key')
                ->label(__('Key'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('value')
                ->label(__('Value'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('expiration')
                ->label(__('Expiration'))
                ->sortable()
                ->searchable()
                ->filterable(),
        ];
    }
    public function getButtons()
    {
        return [
            Button::make('deleteSelected')
                ->icon('bi-trash')
                ->title(__('Delete selected'))
                ->label(__('Delete'))
                ->color('red')
                ->attributes(['wire:confirm' => __('Are you shure to delete selected?')])
                ->disabled(!$this->hasSelected()),
            Button::make('flushAll')
                ->icon('bi-arrow-clockwise')
                ->title(__('Flush all'))
                ->label(__('Flush'))
                ->color('blue')
                ->attributes(['wire:confirm' => __('Are you shure to flush all?')]),
            Button::make('artisanClear')
                ->icon('bi-trash2')
                ->title(__('php artisan cache:clear'))
                ->label(__('Clear'))
                ->color('yellow')
                ->attributes(['wire:confirm' => __('Are you shure to clear cache?')]),
        ];
    }
    public function getActions()
    {
        return [
            taction('delete')
                ->icon('bi-trash')
                ->title(__('Delete')),
        ];
    }
    public function authorizeDelete($id)
    {
        $this->authorize('manage_settings');
    }
    public function cleanCachedImages()
    {
        $folder = Storage::disk(config('imgen.disk_name'))->path(config('imgen.folder'));
        if (File::exists($folder)) {
            File::cleanDirectory($folder);
        }
    }
    public function flushAll()
    {
        $this->authorize('manage_settings');
        try {
            CacheItem::query()->delete();
            Cache::flush();
            $this->cleanCachedImages();
            $this->resetPage();
            $this->toastSuccess('Flush done.');
        } catch (\Exception $e) {
            $this->toastError(__('Flush failed: :error', ['error' => $e->getMessage()]));
        }
    }
    public function artisanClear()
    {
        try {
            Artisan::call('cache:clear');
            $this->cleanCachedImages();
            $this->resetPage();
            $this->toastSuccess(Artisan::output());
        } catch (\Exception $e) {
            $this->toastError(__('Artisan clear failed: :error', ['error' => $e->getMessage()]));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.cache.index')->layout('layouts.dashboard', [
            'title' => __('Cache manager'),
        ]);
    }
}
