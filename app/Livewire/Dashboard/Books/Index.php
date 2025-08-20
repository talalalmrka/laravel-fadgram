<?php

namespace App\Livewire\Dashboard\Books;

use App\Livewire\Components\Datatable\Datatable;
use App\Models\Book;

class Index extends Datatable
{
    public $id_column = true;
    public $author_id = null;
    public $category_id = null;
    public $publish_status = null;
    public function builder()
    {
        $query = Book::query();
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
    public function getColumns()
    {
        return [
            column('author')
                ->label(__('Author'))
                ->sortable()
                ->content(fn(Book $book) => thumbnail([
                    'title' => a([
                        'href' => $book->author_permalink,
                        'target' => '_blank',
                        'label' => $book->author_name,
                    ]),
                    'image' => $book->author?->getThumbnailUrl('xs'),
                ])),

            column('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Book $book) => a([
                    'href' => $book->permalink,
                    'title' => $book->name,
                    'target' => '_blank',
                    'label' => $book->name,
                ])),

            column('slug')
                ->label(__('Slug'))
                ->sortable()
                ->searchable()
                ->filterable(),

            column('downloads')
                ->label(__('Downloads'))
                ->sortable()
                ->searchable()
                ->filterable(),

            column('reads')
                ->label(__('Reads'))
                ->sortable()
                ->searchable()
                ->filterable(),

            column('file_type')
                ->label(__('File type'))
                ->sortable()
                ->searchable()
                ->filterable(),

            column('file_size')
                ->label(__('File size'))
                ->sortable()
                ->searchable()
                ->filterable(),

            column('pages')
                ->label(__('Pages'))
                ->sortable()
                ->searchable()
                ->filterable(),

            column('categories')
                ->label(__('Categories'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Book $book) => container([
                    'class' => 'flex-space-2 flex-wrap',
                    'content' => $book->categoriesLinks(['class' => 'link inline-block text-xs badge xs truncate badge-blue pill badge-outline']),
                ])),

            column('status')
                ->label(__('Status'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Book $book) => status_badge($book->status)),

            column('template')
                ->label(__('Template'))
                ->content(fn(Book $book) => template_badge($book->template)),
        ];
    }
    public function getActions()
    {
        return [
            taction('show')
                ->icon('bi-eye')
                ->title(__('Show'))
                ->target('_blank')
                ->href(fn(Book $book) => $book->permalink),
            taction('edit')
                ->icon('bi-pencil-square')
                ->title(__('Edit'))
                ->target('_blank')
                ->href(fn(Book $book) => $book->edit_url),
            taction('delete')->icon('bi-trash')->title(__('Delete')),
        ];
    }
    public function render()
    {
        return view('livewire.dashboard.books.index')->layout('layouts.dashboard', [
            'title' => __('Books'),
        ]);
    }
}
