<?php

namespace App\Livewire\Dashboard\Comments;

use App\Livewire\Components\Datatable\Datatable;
use App\Models\Comment;


class Index extends Datatable
{
    public function builder()
    {
        return Comment::query();
    }
    public function getColumns()
    {
        return [
            column('user_id')
                ->label(__('User'))
                ->sortable()
                ->content(fn(Comment $comment) => thumbnail([
                    'title' => a([
                        'href' => $comment->user?->permalink,
                        'target' => '_blank',
                        'label' => $comment->user?->display_name,
                    ]),
                    'image' => $comment->user?->getAvatarUrl('xs')
                ])),
            column('model_type')
                ->label(__('Model'))
                ->sortable()
                ->content(fn(Comment $comment) => thumbnail([
                    'title' => a([
                        'href' => $comment->commentable->permalink,
                        'target' => '_blank',
                        'label' => $comment->commentable->name,
                    ]),
                    'image' => $comment->commentable?->getThumbnailUrl('xs'),
                ])),

            column('rating')
                ->label(__('Rating'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(Comment $comment) => rating(['rating' => $comment->rating])),
            column('approved')
                ->label(__('Approved'))
                ->sortable()
                ->content(fn(Comment $comment) => view('livewire.dashboard.comments.approve-cell', [
                    'comment' => $comment,
                ])),
        ];
    }
    public function edit($id)
    {
        $this->dispatch('edit', 'comment', $id);
    }
    public function create()
    {
        $this->dispatch('edit', 'comment');
    }
    public function toggleApproved(Comment $comment)
    {
        $comment->approved = !$comment->approved;
        $save = $comment->save();
        if ($save) {
            $this->toastSuccess(__($comment->approved ? __('Approved') : __('Denied')));
        } else {
            $this->toastError(__('Action failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.comments.index')->layout('layouts.dashboard', [
            'title' => __('Comments'),
        ]);
    }
}
