<?php

namespace App\Livewire\Dashboard\Comments;

use App\Models\Comment;
use App\Traits\WithEditModelDialog;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'comment';
    #[Locked]
    public Comment $comment;
    public $rating;
    public $content;
    public $approved = false;

    protected $fillable_data = ['rating', 'content', 'approved'];
    public function mount(Comment $comment)
    {
        $this->authorize('manage_comments');
        $this->comment = $comment;
    }
    public function afterFill()
    {
        $this->approved = boolval($this->comment->approved);
    }
    public function rules()
    {
        return [
            'rating' => ['numeric', 'min:0', 'max:5'],
            'content' => ['nullable', 'string', 'max:255'],
            'approved' => ['nullable', 'boolean'],
        ];
    }
}
