<?php

namespace App\Livewire\Dashboard\Posts;

use App\Livewire\Components\Datatable\Datatable;

use App\Models\Post;

class Index extends Datatable
{
    public $id_column = true;
    public $user_id = null;
    public $category_id = null;
    public $publish_status = null;
    public function builder()
    {
        $query = Post::type('post');
        if (!empty($this->user_id)) {
            $query->where('user_id', $this->user_id);
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
            column('user_id')
                ->label(__('Author'))
                ->sortable()
                ->content(fn(Post $post) => thumbnail([
                    'title' => a([
                        'href' => $post->user?->permalink,
                        'target' => '_blank',
                        'label' => $post->user?->display_name,
                    ]),
                    'image' => $post->user?->getFirstMediaUrl('avatar'),
                ])),

            column('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Post $post) => a([
                    'href' => $post->permalink,
                    'title' => $post->name,
                    'target' => '_blank',
                    'label' => $post->name,
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
                ->content(fn(Post $post) => container([
                    'class' => 'flex-space-2 flex-wrap',
                    'content' => $post->categoriesLinks(['class' => 'link inline-block text-xs badge xs truncate badge-blue pill badge-outline']),
                ])),

            column('status')
                ->label(__('Status'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Post $post) => status_badge($post->status)),

            column('type')
                ->label(__('Type'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center')
                ->content(fn(Post $post) => post_type_badge($post->type)),

            column('template')
                ->label(__('Template'))
                ->content(fn(Post $post) => template_badge($post->template)),
        ];
    }

    public function getActions()
    {
        return [
            taction('show')
                ->icon('bi-eye')
                ->title(__('Show'))
                ->target('_blank')
                ->href(fn(Post $post) => $post->permalink),

            taction('edit')
                ->icon('bi-pencil-square')
                ->title(__('Edit'))
                ->target('_blank')
                ->href(fn(Post $post) => $post->edit_url),

            taction('delete')->icon('bi-trash')->title(__('Delete')),
        ];
    }
    public function render()
    {
        return view('livewire.dashboard.posts.index')->layout('layouts.dashboard', [
            'title' => __('Posts'),
        ]);
    }
}
