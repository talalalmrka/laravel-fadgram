<?php

namespace App\Livewire\Dashboard\Books;

use \Imagick;
use App\Models\Book;
use App\Traits\WithEditModel;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'book';
    #[Locked]
    public ?Book $book;
    public $user_id;
    public $author_id;
    public $name;
    public $slug;
    public $status = 'draft';
    public $content = '';

    public $year;
    public $pages;
    public $downloads;
    public $reads;
    public $template;
    public $seo_title;
    public $seo_description;

    public $thumbnail;
    public $file;
    public $categories = [];
    public $tags = [];

    protected $fillable_data = ['user_id', 'author_id', 'name', 'slug', 'status', 'content'];
    protected $fillable_meta = ['year', 'pages', 'downloads', 'reads', 'seo_title', 'seo_description', 'template'];
    protected $fillable_media = ['thumbnail', 'file'];
    public function mount(?Book $book)
    {
        $this->book = $book;
    }
    public function afterFill()
    {
        $this->author_id = $this->book->author_id;
        $this->categories = $this->book->getCategoryIds()->toArray();
        $this->tags = $this->book->getTagIds()->toArray();
    }
    /* public function editTitle()
    {
        return __('Edit book :name', ['name' => $this->name]);
    }
    public function createTitle()
    {
        return __('Create book');
    } */
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'author_id' => ['nullable', 'numeric', Rule::exists('authors', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('books', 'slug')->ignore($this->book)],
            'status' => ['required', 'string', Rule::in(status_values())],
            'content' => ['nullable', 'string'],
            'year' => ['nullable', 'string', 'max:255'],
            'pages' => ['nullable', 'numeric'],
            'downloads' => ['nullable', 'numeric'],
            'reads' => ['nullable', 'numeric'],
            'template' => ['nullable', 'string', Rule::in(templates())],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:102400'], // 100MB max for PDF files
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
        ];
    }
    public function beforeSave()
    {
        if (empty($this->slug)) {
            $this->slug = Book::generateSlug($this->name);
        }
        if (empty($this->user_id)) {
            $this->user_id = auth()->user()->id;
        }
    }
    public function afterSave()
    {
        $this->book->syncCategories($this->categories);
        $this->book->syncTags($this->tags);
        $this->book->assignAuthor($this->author_id);
    }
    public function statusKey()
    {
        return 'save';
    }
    public function updatedFile()
    {
        $this->validateOnly('file');
        if ($this->file && $this->file->isValid() && $this->file->getClientOriginalExtension() === 'pdf') {
            try {
                $pdfPath = $this->file->getRealPath();
                $content = @file_get_contents($pdfPath);
                if ($content !== false) {
                    preg_match_all('/\/Type\s*\/Page\b/', $content, $matches);
                    $this->pages = count($matches[0]);
                }
            } catch (\Exception $e) {
                $this->toastError(error_message($e, __('Fetch pdf pages count failed')));
            }
        }
    }
    public function render()
    {
        return view('livewire.dashboard.books.edit', [
            'previewsThumbnail' => $this->getPreviews('thumbnail'),
            'previewsFile' => $this->getPreviews('file'),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
