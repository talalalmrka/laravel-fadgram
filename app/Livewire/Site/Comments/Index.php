<?php

namespace App\Livewire\Site\Comments;

use App\Models\Comment;
use App\Traits\WithToast;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class Index extends Component
{
    use WithoutUrlPagination, WithToast;
    public $model;
    public $rating = true;
    public $perPage;
    public $sort;
    public $search;
    public $title = null;
    public $titleIcon = 'bi-chat text-primary';
    public $newRating;
    public $newComment;
    public $page = 1;
    public $class = null;
    public $atts = [];
    public $headingClass = null;
    public $headingAtts = [];
    public $titleClass = 'text-base md:text-lg lg:text-xl mb-0';
    public $titleAtts = null;
    public $titleTag = 2;
    public $headingStripColor = 'primary';
    public function mount($model)
    {
        $this->model = $model;
        $this->perPage = (int) get_option('comments_per_page', 5);
        $this->sort = get_option('comments_sort');
        $this->newRating = request('rating');
        $this->newComment = request('comment');
    }
    public function rules()
    {
        $rules = [
            'newComment' => ['nullable', 'required_if:rating,false', 'string', 'max:255'],
        ];
        if ($this->rating) {
            $rules['newRating'] = ['required_if:rating,true', 'numeric', 'min:1', 'max:5'];
        }
        return $rules;
    }
    public function sorts()
    {
        return [
            'newest' => [
                'field' => 'id',
                'direction' => 'desc',
                'label' => __('Newest top'),
            ],
            'oldest' => [
                'field' => 'id',
                'direction' => 'asc',
                'label' => __('Oldest top'),
            ],
        ];
    }
    public function count()
    {
        return $this->model->approvedComments()->count();
    }
    public function maxPages()
    {
        $total = $this->comments()->count();
        return (int) ceil($total / $this->perPage);
    }
    public function hasMore()
    {
        return $this->page < $this->maxPages();
    }
    public function loadMore()
    {
        if ($this->hasMore()) {
            $this->page++;
        }
    }

    public function comments()
    {
        $query = $this->model->comments();
        if (!can('manage_comments')) {
            if (auth()->check()) {
                $query->where(function ($q) {
                    $q->where('approved', true);
                    $q->orWhere(function ($q2) {
                        $q2->where('user_id', auth()->id())->where('approved', false);
                    });
                });
            } else {
                $query->where('approved', true);
            }
        }
        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $sort = $this->sort;
        $field = data_get($this->sorts(), "{$sort}.field");
        $direction = data_get($this->sorts(), "{$sort}.direction");
        if ($field) {
            $query->orderBy($field, $direction);
        }
        return $query;
    }

    public function approved()
    {
        if (can('manage_comments')) {
            return true;
        }
        $approved = true;
        if (get_option('comments_approve_required')) {
            $approved = false;
        }
        if (auth()->check() && get_option('comments_approve_previuos')) {
            $approvedCount = auth()->user()->approvedComments()->count();
            if ($approvedCount) {
                $approved = true;
            }
        }
        return $approved;
    }
    public function sendComment()
    {
        if (!auth()->check()) {
            return $this->redirect(route('login', ['rdr' => $this->model->permalink . "?rating={$this->newRating}&comment={$this->newComment}"]));
        }
        $this->validate();
        $data = [
            'user_id' => current_user_id(),
            'content' => $this->newComment,
            'approved' => $this->approved(),
        ];
        if ($this->rating) {
            $data['rating'] = $this->newRating;
        }
        $send = $this->model->comments()->create($data);
        if ($send) {
            $this->reset('newRating', 'newComment');
            $this->addSuccess('send_comment', __('Review sent.'));
        } else {
            $this->addError('send_comment', __('Send failed!'));
        }
    }
    public function toggleApprove(Comment $comment)
    {
        $this->authorize('manage_comments');
        $comment->approved = !$comment->approved;
        $save = $comment->save();
        if ($save) {
            $this->toastSuccess(__('Toggled'));
        } else {
            $this->toastError(__('Toggle failed!'));
        }
    }
    public function deleteComment(Comment $comment)
    {
        if (!can('manage_comments') && $comment->user_id !== current_user_id()) {
            abort(403, __('You have not permissions'));
        }
        $delete = $comment->delete();

        if ($delete) {
            $this->toastSuccess(__('Deleted'));
        } else {
            $this->toastError(__('Delete failed!'));
        }
    }
    public function render()
    {
        return view('livewire.site.comments.index', [
            'comments' => $this->comments()->take($this->page * $this->perPage)->get(),
            'count' => $this->count(),
            'hasMore' => $this->hasMore(),
            'max' => $this->maxPages(),
        ]);
    }
}
