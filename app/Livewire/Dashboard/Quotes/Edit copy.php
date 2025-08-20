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
    public $author_id;
    public $name;
    public $slug;
    public $status = 'draft';
    public $content = '';

    public $excerpt;
    public $template = 'default';
    public $seo_title;
    public $seo_description;

    public $thumbnail;
    public $categories = [];
    public $quoteImageIds = [];
    public $quoteImagesPage = 1;
    // public $quoteImagesPerPage = 20;
    // public $quoteImagesCat = null;
    // public $sort = 'newest';
    public $tags = [];

    public $filters = [
        'sort' => 'newest',
        'perPage' => 20,
        'category' => null,
    ];

    protected $fillable_data = ['user_id', 'name', 'slug', 'status', 'content'];
    protected $fillable_meta = ['excerpt', 'seo_title', 'seo_description', 'template'];
    protected $fillable_media = ['thumbnail'];
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
        $this->quoteImageIds = $this->quote->getQuoteImageIds()->toArray();
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
            "user_id" => ["required", "integer", Rule::exists('users', 'id')],
            "author_id" => ["nullable", "integer", Rule::exists('authors', 'id')],
            "name" => ["required", "string", "max:255"],
            "slug" => ["required", "string", "max:255", Rule::unique("quotes", "slug")->ignore($this->quote)],
            "status" => ["required", "string", Rule::in(status_values())],
            "content" => ["nullable", "string",],
            "template" => ["nullable", "string", Rule::in(templates())],
            "seo_title" => ["nullable", "string", "max:255"],
            "seo_description" => ["nullable", "string", "max:255"],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
            'quoteImageIds' => ['nullable', 'array'],
            'quoteImageIds.*' => ['nullable', 'integer', Rule::exists('quote_images', 'id')],
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
        $this->quote->syncCategories($this->categories);
        $this->quote->syncTags($this->tags);
        $this->quote->syncQuoteImages($this->quoteImageIds);
        if ($this->editUrl !== $this->quote->edit_url) {
            $this->redirect($this->quote->edit_url, true);
        }
    }
    public function statusKey()
    {
        return 'save';
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
    public function sortOptions()
    {
        return arr_map(array_keys($this->sorts()), fn($sort) => ['label' => data_get($this->sorts(), "{$sort}.label"), 'value' => $sort]);
    }
    public function perPageOptions()
    {
        return arr_map([5, 10, 15, 20, 25, 30, 35, 40, 45, 50], fn($num) => ['label' => $num, 'value' => $num]);
    }
    public function categoryOptions()
    {
        // Get categories that have at least one QuoteImage
        return Category::whereHas('quoteImages')
            ->where('type', 'category')
            ->orderBy('name')
            ->get()
            ->map(fn(Category $cat) => ['label' => $cat->name, 'value' => $cat->id])->toArray();
    }
    public function quoteImages()
    {
        $query = QuoteImage::query();
        $cat = data_get($this->filters, 'cat');
        if (!empty($cat)) {
            $query->category($cat);
        }
        $sort = data_get($this->filters, 'sort');
        if ($sort) {
            $field = data_get($this->sorts(), "{$sort}.field");
            $direction = data_get($this->sorts(), "{$sort}.direction");
            if ($field && $direction) {
                $query->orderBy($field, $direction);
            }
        }
        $perPage = intval(data_get($this->filters, 'perPage')) ?? 20;
        return $query->paginate($perPage);
    }
    /* public function maxQuoteImagesPage()
    {
        $totalImages = QuoteImage::count();
        $maxPage = (int) ceil($totalImages / $this->quoteImagesPerPage);
        return $maxPage;
    }
    public function nextQuoteImagesPage()
    {
        if (!isset($this->quoteImagesPage)) {
            $this->quoteImagesPage = 1;
        }
        if ($this->quoteImagesPage < $this->maxQuoteImagesPage()) {
            $this->quoteImagesPage++;
        }
    }
    public function prevQuoteImagesPage()
    {
        if (!isset($this->quoteImagesPage)) {
            $this->quoteImagesPage = 1;
        }
        if ($this->quoteImagesPage > 1) {
            $this->quoteImagesPage--;
        }
    } */
    public function toggleImage(QuoteImage $quoteImage)
    {
        if (in_array($quoteImage->id, $this->quoteImageIds)) {
            $this->quoteImageIds = array_values(array_diff($this->quoteImageIds, [$quoteImage->id]));
        } else {
            $this->quoteImageIds[] = $quoteImage->id;
        }
    }
    public function render()
    {
        return view("livewire.dashboard.quotes.edit", [
            'previewsThumbnail' => $this->getPreviews('thumbnail'),
            'quoteImages' => $this->quoteImages(),
            // 'maxPages' => $this->maxQuoteImagesPage(),
            'sortOptions' => $this->sortOptions(),
            'perPageOptions' => $this->perPageOptions(),
            'categoryOptions' => $this->categoryOptions(),
            // 'previewsImages' => $this->getPreviews('images'),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
