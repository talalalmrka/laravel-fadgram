<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    /**
     * Get all of the model's comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'model');
    }

    /**
     * Get only approved comments.
     */
    public function approvedComments(): MorphMany
    {
        return $this->comments()->where('approved', true);
    }

    /**
     * Count of all comments.
     */
    public function commentsCount(): int
    {
        return $this->comments()->count();
    }

    /**
     * Add a comment to the model.
     *
     * @param array $attributes
     * @return \App\Models\Comment
     */
    public function addComment(array $attributes)
    {
        return $this->comments()->create($attributes);
    }

    /**
     * Approve a comment by its ID.
     *
     * @param int $commentId
     * @return bool
     */
    public function approveComment(int $commentId): bool
    {
        $comment = $this->comments()->find($commentId);
        if ($comment) {
            $comment->approved = true;
            return $comment->save();
        }
        return false;
    }

    /**
     * Toggle Approve a comment by its ID.
     *
     * @param int $commentId
     * @return bool
     */
    public function toggleCommentApprove(int $commentId): bool
    {
        $comment = $this->comments()->find($commentId);
        if ($comment) {
            $comment->approved = !$comment->approved;
            return $comment->save();
        }
        return false;
    }
    /**
     * Delete comment by its ID.
     *
     * @param int $commentId
     * @return bool
     */
    public function deleteComment(int $commentId): bool
    {
        return $this->comments()->destroy($commentId);
    }
    public function rating(): Attribute
    {
        return Attribute::get(fn() => (int) round($this->approvedComments()->avg('rating') ?? 0));
    }
    public function getReviewProgressAttribute(): array
    {
        $totalReviews = $this->approvedComments()->count();
        $progress = [];

        if ($totalReviews > 0) {
            foreach (range(1, 5) as $rating) {
                $count = $this->approvedComments()
                    ->where('rating', $rating)
                    ->count();
                $progress[$rating] = round(($count / $totalReviews) * 100, 2); // percentage
            }
        } else {
            // No reviews yet
            foreach (range(1, 5) as $rating) {
                $progress[$rating] = 0;
            }
        }

        // Sort by percentage in descending order
        arsort($progress);

        return $progress;
    }
    public function singleMetaComments()
    {
        return (bool) get_option(strtolower(class_basename($this)) . '_meta_comments');
    }
}
