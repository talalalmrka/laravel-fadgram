<?php

namespace App\Livewire\Site\Books;

use App\Models\Book;
use App\Traits\WithToast;
use App\Traits\WithToggleFavorite;
use Livewire\Component;

class Single extends Component
{
    use WithToast,
        WithToggleFavorite;
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
            'seo_description' => $this->book->seo_description,
        ]);
    }
}
