<?php

namespace App\Livewire\Dashboard\Pages;

use App\Models\Page;
use App\Traits\WithEditModel;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'page';
    #[Locked]
    public ?Page $page;
    public $user_id;
    public $name;
    public $slug;
    public $type = 'page';
    public $status = 'trash';
    public $content = '';

    public $template;
    public $seo_title;
    public $seo_description;

    public $thumbnail;
    public $files = [];
    public $categories = [];
    public $tags = [];

    protected $fillable_data = ['user_id', 'name', 'slug', 'type', 'status', 'content'];
    protected $fillable_meta = ['seo_title', 'seo_description', 'template'];
    protected $fillable_media = ['thumbnail', 'files'];
    public function mount(?Page $page)
    {
        $this->page = $page;
    }
    public function afterFill()
    {
        $this->type = 'page';
        $this->categories = $this->page->getCategoryIds()->toArray();
        $this->tags = $this->page->getTagIds()->toArray();
    }
    public function rules()
    {
        return [
            "user_id" => ["required", "integer", Rule::exists('users', 'id')],
            "name" => ["required", "string", "max:255"],
            "slug" => ["required", "string", "max:255", Rule::unique("posts", "slug")->ignore($this->page)],
            "type" => ["required", "string", Rule::in(['page'])],
            "status" => ["required", "string", Rule::in(['draft', 'publish', 'trash'])],
            "content" => ["nullable", "string",],
            "template" => ["nullable", "string", Rule::in(config('layouts.layouts'))],
            "seo_title" => ["nullable", "string", "max:255"],
            "seo_description" => ["nullable", "string", "max:255"],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'file'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
        ];
    }
    public function title()
    {
        return $this->saved()
            ? __('Edit page :name', ['name' => $this->name])
            : __('Create page');
    }
    public function beforeSave()
    {
        if (empty($this->slug)) {
            $this->slug = Page::generateSlug($this->name);
        }
        if (empty($this->user_id)) {
            $this->user_id = auth()->user()->id;
        }
        $this->type = 'page';
    }
    public function afterSave()
    {
        $this->page->syncCategories($this->categories);
        $this->page->syncTags($this->tags);
        $currentUrl = url()->current();
        $this->toastInfo('its edit current :current, url :url', ['current' => $currentUrl, 'url' => $this->page->edit_url]);
        if ($this->page && url()->current() !== $this->page->edit_url) {
            $this->toastError('Not edit :url', ['url' => $this->page->edit_url]);
            //$this->redirect(route('dashboard.pages.edit', $this->page), true);
        }
    }
    public function statusKey()
    {
        return 'save';
    }

    public function render()
    {
        return view("livewire.dashboard.pages.edit", [
            'previewsThumbnail' => $this->getPreviews('thumbnail'),
            'previewsFiles' => $this->getPreviews('files'),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
