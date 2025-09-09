<?php

namespace App\Livewire\Dashboard\Quotes;

use App\Models\Category;
use App\Models\Quote;
use App\Models\QuoteImage;
use App\Traits\WithEditModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithEditModel, WithPagination, WithoutUrlPagination;
    protected $model_type = 'quote';
    #[Locked]
    public ?Quote $quote;
    public $user_id;
    public $quote_image_id;
    public $author_id;
    public $name;
    public $slug;
    public $status = 'draft';
    public $content = '';

    public $excerpt;
    public $views = 1;
    public $template = 'default';
    public $seo_title;
    public $seo_description;

    public $categories = [];
    public $tags = [];

    public $image;
    public $images = [];
    public $selectImages = [
        'show' => false,
        'model' => null,
        'multiple' => false,
        'label' => null,
        'key' => 'default',
    ];

    protected $fillable_data = ['user_id', 'quote_image_id', 'name', 'slug', 'status', 'content'];
    protected $fillable_meta = ['views', 'excerpt', 'seo_title', 'seo_description', 'template'];
    protected $fillable_media = [];
    public $editUrl;
    public function mount(?Quote $quote)
    {
        $this->editUrl = $quote->edit_url;
        $this->quote = $quote;
    }
    public function afterFill()
    {
        $this->categories = $this->quote->getCategoryIds()->toArray();
        $this->tags = $this->quote->getTagIds()->toArray();
        $this->author_id = $this->quote->author_id;
        $this->images = $this->quote->getQuoteImageIds()->toArray();
        if (empty($this->template)) {
            $this->template = get_option('quote_template', 'default');
        }
        if (empty($this->status)) {
            $this->status = 'draft';
        }
    }
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'quote_image_id' => ['nullable', 'integer', Rule::exists('quote_images', 'id')],
            'author_id' => ['nullable', 'integer', Rule::exists('authors', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('quotes', 'slug')->ignore($this->quote)],
            'status' => ['required', 'string', Rule::in(status_values())],
            'content' => ['nullable', 'string',],
            'template' => ['nullable', 'string', Rule::in(templates())],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'views' => ['nullable', 'numeric'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'integer', Rule::exists('quote_images', 'id')],
        ];
    }
    public function beforeSave()
    {
        if (empty($this->slug)) {
            $this->slug = Quote::generateSlug($this->name);
        }
        if (empty($this->user_id)) {
            $this->user_id = auth()->user()->id;
        }
    }
    public function afterSave()
    {
        if ($this->author_id) {
            $this->quote->assignAuthor($this->author_id);
        }
        $this->quote->syncCategories($this->categories);
        $this->quote->syncTags($this->tags);
        $this->quote->syncQuoteImages($this->images);
        if ($this->editUrl !== $this->quote->edit_url) {
            $this->redirect($this->quote->edit_url, true);
        }
    }
    public function statusKey()
    {
        return 'save';
    }
    public function editPrimaryImage()
    {
        $this->selectImages = [
            'show' => true,
            'model' => 'quote_image_id',
            'multiple' => false,
            'label' => __('Select primary image'),
            'key' => uniqid('images-'),
        ];
    }
    public function removePrimaryImage()
    {
        $this->quote_image_id = null;
    }
    public function primaryImage()
    {
        return !empty($this->quote_image_id) ? QuoteImage::find($this->quote_image_id) : null;
    }
    public function addImage()
    {
        $this->selectImages = [
            'show' => true,
            'model' => 'images',
            'multiple' => true,
            'label' => __('Add quote images'),
            'key' => uniqid('images-'),
        ];
    }
    public function removeImage(QuoteImage $quoteImage)
    {
        $this->images = array_values(array_diff($this->images, [$quoteImage->id]));
    }
    public function quoteImages()
    {
        return QuoteImage::whereIn('id', array_values($this->images))->get();
    }
    public function render()
    {
        return view('livewire.dashboard.quotes.edit', [
            'quoteImages' => $this->quoteImages(),
            'primaryImage' => $this->primaryImage(),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
