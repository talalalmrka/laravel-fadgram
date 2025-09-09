<?php

namespace App\Livewire\Dashboard\Quotes;

use App\Livewire\Components\Datatable\Buttons\Button;
use App\Livewire\Components\Datatable\Datatable;
use App\Models\Quote;

class Index extends Datatable
{
    public $id_column = true;
    public $author_id = null;
    public $category_id = null;
    public $publish_status = null;
    public function builder()
    {
        $query = Quote::query();
        if (!empty($this->author_id)) {
            $query->author($this->author_id);
        }
        if (!empty($this->category_id)) {
            $query->category($this->category_id);
        }
        if (!empty($this->publish_status)) {
            $query->status($this->publish_status);
        }
        return $query;
    }
    public function getButtons()
    {
        return [
            Button::make('create')
                ->icon('bi-plus-lg')
                ->title(__('Create'))
                ->color('emerald'),

            Button::make('bulk_create')
                ->icon('bi-window-plus')
                ->title(__('Create multiple'))
                ->color('lime'),

            Button::make('publishSelected')
                ->icon('bi-check2-circle')
                ->title(__('Publish'))
                ->color('sky')
                ->disabled(!$this->hasSelected()),

            Button::make('draftSelected')
                ->icon('bi-clock')
                ->title(__('Draft'))
                ->color('secondary')
                ->class('btn-orange')
                ->disabled(!$this->hasSelected()),

            Button::make('trashSelected')
                ->icon('bi-trash')
                ->title(__('Move to trash'))
                ->color('orange')
                ->class('btn-orange')
                ->disabled(!$this->hasSelected()),

            Button::make('deleteSelected')
                ->icon('bi-x-lg')
                ->title(__('Delete'))
                ->color('red')
                ->attributes(['wire:confirm' => __('Are you shure to delete selected?')])
                ->disabled(!$this->hasSelected()),
        ];
    }
    public function getColumns()
    {
        return [
            column('author')
                ->label(__('Author'))
                ->sortable()
                ->content(fn(Quote $quote) => thumbnail([
                    'title' => a([
                        'href' => $quote->author_permalink,
                        'target' => '_blank',
                        'label' => $quote->author_name,
                    ]),
                    'image' => $quote->author?->getThumbnailUrl('xs'),
                ])),

            column('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Quote $quote) => a([
                    'href' => $quote->permalink,
                    'title' => $quote->name,
                    'target' => '_blank',
                    'label' => $quote->name,
                ])),

            column('slug')
                ->label(__('Slug'))
                ->sortable()
                ->searchable()
                ->filterable(),

            column('categories')
                ->label(__('Categories'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Quote $quote) => container([
                    'class' => 'flex-space-2 flex-wrap',
                    'content' => $quote->categoriesLinks(['class' => 'link inline-block badge xs truncate badge-blue pill badge-outline']),
                ])),

            column('status')
                ->label(__('Status'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Quote $quote) => status_badge($quote->status)),

            column('template')
                ->label(__('Template'))
                ->content(fn(Quote $quote) => template_badge($quote->template)),
        ];
    }
    public function getActions()
    {
        return [
            taction('show')
                ->icon('bi-eye')
                ->title(__('Show'))
                ->target('_blank')
                ->href(fn(Quote $quote) => $quote->permalink),
            taction('edit')
                ->icon('bi-pencil-square')
                ->title(__('Edit'))
                ->target('_blank')
                ->href(fn(Quote $quote) => $quote->edit_url),
            taction('delete')->icon('bi-trash')->title(__('Delete')),
        ];
    }
    public function bulk_create()
    {
        $this->authorizeCreate();
        $this->redirect(route('dashboard.quotes.create.bulk'), true);
    }
    public function updateSelectedStatus($status)
    {
        $this->authorize('manage_quotes');
        $this->builder()->whereIn('id', $this->selected)->update(['status' => $status]);
    }
    public function publishSelected()
    {
        $this->updateSelectedStatus('publish');
    }
    public function draftSelected()
    {
        $this->updateSelectedStatus('draft');
    }
    public function trashSelected()
    {
        $this->updateSelectedStatus('trash');
    }
    public function render()
    {
        return view('livewire.dashboard.quotes.index')->layout('layouts.dashboard', [
            'title' => __('Quotes'),
        ]);
    }
}
