<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post;
use App\Traits\WithEditModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'post';
    #[Locked]
    public ?Post $post;
    public $user_id;
    public $name;
    public $slug;
    public $type = 'post';
    public $status = 'draft';
    public $content = '';

    public $excerpt;
    public $template = 'default';
    public $seo_title;
    public $seo_description;

    public $thumbnail;
    public $categories = [];
    public $tags = [];

    public $images;

    protected $fillable_data = ['user_id', 'name', 'slug', 'type', 'status', 'content'];
    protected $fillable_meta = ['excerpt', 'seo_title', 'seo_description', 'template'];
    protected $fillable_media = ['thumbnail', 'images'];
    public $editUrl;
    public function mount(?Post $post)
    {
        $this->editUrl = $post->edit_url;
        $post->type = $this->type;
        $this->post = $post;
    }
    public function afterFill()
    {
        $this->categories = $this->post->getCategoryIds()->toArray();
        $this->tags = $this->post->getTagIds()->toArray();
        if (empty($this->template)) {
            $this->template = get_option('post_template', 'default');
        }
        if (empty($this->status)) {
            $this->status = 'draft';
        }
    }
    public function rules()
    {
        return [
            "user_id" => ["required", "integer", Rule::exists('users', 'id')],
            "name" => ["required", "string", "max:255"],
            "slug" => ["required", "string", "max:255", Rule::unique("posts", "slug")->ignore($this->post)],
            "type" => ["required", "string", Rule::in(['post', 'page'])],
            "status" => ["required", "string", Rule::in(['draft', 'publish', 'trash'])],
            "content" => ["nullable", "string",],
            "template" => ["nullable", "string", Rule::in(templates())],
            "seo_title" => ["nullable", "string", "max:255"],
            "seo_description" => ["nullable", "string", "max:255"],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'tag')],
        ];
    }
    public function beforeSave()
    {
        if (empty($this->slug)) {
            $this->slug = Post::generateSlug($this->name);
        }
        if (empty($this->user_id)) {
            $this->user_id = auth()->user()->id;
        }
    }
    public function afterSave()
    {
        $this->post->syncCategories($this->categories);
        $this->post->syncTags($this->tags);
        if ($this->editUrl !== $this->post->edit_url) {
            $this->redirect($this->post->edit_url, true);
        }
    }
    public function statusKey()
    {
        return 'save';
    }
    #[Computed]
    public function plural()
    {
        return plural($this->type);
    }
    public function render()
    {
        return view("livewire.dashboard.posts.edit", [
            'previewsThumbnail' => $this->getPreviews('thumbnail'),
            'previewsImages' => $this->getPreviews('images'),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
