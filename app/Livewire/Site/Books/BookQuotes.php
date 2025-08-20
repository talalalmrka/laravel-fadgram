<?php

namespace App\Livewire\Site\Books;

use App\Models\Book;
use App\Models\Quote;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToast;
use Livewire\Attributes\Locked;
use Livewire\Component;

class BookQuotes extends Component
{
    use WithToast,
        WithDownloadQuoteDialog;
    #[Locked]
    public Book $book;
    public $class = '';
    public $addQuoteEnabled;
    public $approveRequired;
    public $approvePrevious;
    public $perPage;
    public $sort;
    public $search;
    public $title;
    public $titleIcon;
    public $newQuote;
    public $page = 1;
    public $showQuoteModal = false;
    public function mount(Book $book)
    {
        $this->book = $book;
        $this->title = __(get_option('book_quotes_section_title'), ['name' => $this->book->name, 'permalink' => a(['href' => $this->book->permalink, 'label' => $this->book->name])]);
        $this->addQuoteEnabled = (bool) get_option('book_add_quote');
        $this->approveRequired = (bool) get_option('book_quotes_approve_required');
        $this->approvePrevious = (bool) get_option('book_quotes_approve_previous');
        $this->perPage = (int) get_option('book_quotes_per_page', 5);
        $this->sort = get_option('book_quotes_sort');
    }
    public function rules()
    {
        return [
            'newQuote' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function maxPages()
    {
        $total = $this->quotes()->count();
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

    public function quotes()
    {
        $query = $this->book->quotes();
        if (!can('manage_quotes')) {
            if (auth()->check()) {
                $query->where(function ($q) {
                    $q->where('status', 'publish');
                    $q->orWhere(function ($q2) {
                        $q2->where('user_id', auth()->id())->where('status', 'draft');
                    });
                });
            } else {
                $query->where('status', 'publish');
            }
        }
        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('authors', function ($aq) use ($search) {
                        $aq->where('name', 'like', "%{$search}%");
                    });
            });
        }
        if ($this->sort) {
            $field = sort_field($this->sort);
            $direction = sort_direction($this->sort);
            if ($field) {
                $query->orderBy($field, $direction);
            }
        }
        return $query;
    }

    public function newQuoteStatus()
    {
        return match (true) {
            can('manage_quotes') => 'publish',
            $this->approveRequired && !current_user()->publishedQuotes()->count() => 'draft',
            default => 'draft',
        };
    }
    public function addQuote()
    {
        if (!auth()->check()) {
            return $this->redirect(route('login', ['rdr' => $this->book->permalink]));
        }
        $this->showQuoteModal = true;
    }
    public function sendQuote()
    {
        if (!auth()->check()) {
            return $this->redirect(route('login', ['rdr' => $this->model->permalink . "?newQuote={$this->newQuote}"]));
        }
        $this->validate();
        $quoteName = str_limit($this->newQuote, 10, null, true);
        $quote = $this->book->quotes()->create([
            'user_id' => current_user_id(),
            'name' => $quoteName,
            'slug' => Quote::generateSlug($quoteName),
            'status' => $this->newQuoteStatus(),
            'content' => $this->newQuote,
        ]);
        if ($quote) {
            $this->reset('newQuote');
            $this->showQuoteModal = false;
            $this->toastSuccess(__('Quote added'));
        } else {
            $this->toastError(__('Add quote failed'));
        }
    }
    public function toggleStatus(Quote $quote)
    {
        $this->authorize('manage_quotes');
        $quote->status = $quote->status === 'publish' ? 'draft' : 'publish';
        $save = $quote->save();
        if ($save) {
            $this->toastSuccess($quote->status === 'publish' ? __('Published') : __('Drafted'));
        } else {
            $this->toastError(__('Toggle failed!'));
        }
    }
    public function delete(Quote $quote)
    {
        if (!can('manage_quotes') && $quote->user_id !== current_user_id()) {
            abort(403, __('You have not permissions'));
        }
        $delete = $quote->delete();

        if ($delete) {
            $this->toastSuccess(__('Deleted'));
        } else {
            $this->toastError(__('Delete failed!'));
        }
    }
    public function render()
    {
        return view('livewire.site.books.book-quotes', [
            'quotes' => $this->quotes()->take($this->page * $this->perPage)->get(),
            'hasMore' => $this->hasMore(),
        ]);
    }
}
