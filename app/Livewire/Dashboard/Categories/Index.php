<?php

namespace App\Livewire\Dashboard\Categories;

use App\Livewire\Components\Datatable\Datatable;
use App\Models\Category;
use App\Livewire\Components\Datatable\Columns\Column;
use App\Livewire\Components\Datatable\Actions\Action;
use Livewire\Component;

class Index extends Datatable
{
    public $id_column = true;
    public function builder()
    {
        return Category::type('category');
    }
    public function getColumns()
    {
        return [
            Column::make('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(function (Category $category) {
                    return $category->label;
                }),
            Column::make('description')
                ->label(__('Description'))
                ->sortable()
                ->searchable()
                ->filterable(),
            Column::make('slug')
                ->label(__('Slug'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center'),
            Column::make('parent_id')
                ->label(__('Parent'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center')
                ->content(function (Category $category) {
                    return $category->parent_name;
                }),
            Column::make('posts')
                ->label(__('Posts'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center')
                ->content(function (Category $category) {
                    return $category->posts()->count();
                }),
        ];
    }
    public function getActions()
    {
        return [
            Action::make('show')->icon('bi-eye-fill'),
            Action::make('edit')->icon('bi-pencil-square'),
            Action::make('delete')->icon('bi-trash'),
        ];
    }
    public function show($id) {}
    public function edit($id)
    {
        $this->dispatch('edit', 'category', $id);
    }
    public function create()
    {
        $this->dispatch('edit', 'category');
    }
    public function render()
    {
        return view('livewire.dashboard.categories.index')->layout('layouts.dashboard', [
            'title' => __('Categories'),
        ]);
    }
}
