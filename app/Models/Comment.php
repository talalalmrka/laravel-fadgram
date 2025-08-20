<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\WithDate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory,
        WithDate,
        HasAuthor;
    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'rating',
        'content',
        'approved',
    ];
    public function commentable()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }
    public function commentableName(): Attribute
    {
        return Attribute::get(fn() => $this->commentable?->name);
    }
    public function commentablePermalink(): Attribute
    {
        return Attribute::get(fn() => $this->commentable?->permalink);
    }
    public function commentableThumbnailUrl(): Attribute
    {
        return Attribute::get(fn() => $this->commentable?->getThumbnailUrl('xs'));
    }
    public function hasPending()
    {
        return !$this->approved && auth()->check() && $this->user_id === current_user_id();
    }
    public function hasActions()
    {
        return can('manage_comments') || $this->user_id === current_user_id();
    }
    public function hasActionDelete()
    {
        return $this->hasActions();
    }
    public function hasActionApprove()
    {
        return can('manage_comments') && !$this->approved;
    }
    public function hasActionUnApprove()
    {
        return can('manage_comments') && $this->approved;
    }
}
