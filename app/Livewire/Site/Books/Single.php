<?php

namespace App\Livewire\Site\Books;

use App\Models\Book;
use App\Models\Quote;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToast;
use Illuminate\Support\Str;
use Livewire\Component;

class Single extends Component
{
    use WithToast;
    public Book $book;
    public $related;
    public $relatedLabel;
    public function mount(Book $book)
    {
        $book->viewsPlus();
        $this->book = $book;
        $this->related = (bool) get_option('related_books_enabled', false) ? $this->book->related() : null;
        $this->relatedLabel = get_option('related_books_label');
    }

    public function downloadFile()
    {
        if (!$this->book->file) {
            $this->toastError(__('File not found!'));
            return;
        }

        $this->book->downloadsPlus();

        // Download the file
        return response()->download($this->book->file->getPath(), $this->book->file->file_name);
    }

    public function render()
    {
        return view('livewire.site.books.single', [
            'quotes' => $this->book->quotes()->get(),
            'hasMore' => true,
        ])->layout($this->book->layout, [
            'title' => $this->book->name,
            'seo_title' => $this->book->seo_title,
            'description' => $this->book->seo_description,
            /* 'subtitle' => container([
                'tag' => 'span',
                'icon' => 'bi-person-fill',
                'content' => $this->book->author_name,
                'class' => 'justify-center',
            ]),
            'secondSubtitle' => container([
                'tag' => 'span',
                'icon' => 'bi-calendar-fill',
                'content' => $this->book->date_ago,
                'class' => 'justify-center',
            ]), */
            'image' => $this->book->getThumbnailUrl('lg')
        ]);
    }
}
