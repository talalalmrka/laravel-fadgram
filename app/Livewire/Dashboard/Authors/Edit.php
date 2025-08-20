<?php

namespace App\Livewire\Dashboard\Authors;

use App\Models\Author;
use App\Traits\WithEditModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'author';
    #[Locked]
    public ?Author $author;
    public $user_id;
    public $name;
    public $slug;
    public $status = 'trash';
    public $content = '';

    public $template;
    public $seo_title;
    public $seo_description;

    public $thumbnail;

    protected $fillable_data = ['user_id', 'name', 'slug', 'status', 'content'];
    protected $fillable_meta = ['seo_title', 'seo_description', 'template'];
    protected $fillable_media = ['thumbnail'];
    public function mount(?Author $author)
    {
        $this->author = $author;
    }
    public function rules()
    {
        return [
            "user_id" => ["required", "integer", Rule::exists('users', 'id')],
            "name" => ["required", "string", "max:255"],
            "slug" => ["required", "string", "max:255", Rule::unique("authors", "slug")->ignore($this->author)],
            "status" => ["required", "string", Rule::in(['draft', 'publish', 'trash'])],
            "content" => ["nullable", "string",],
            "template" => ["nullable", "string", Rule::in(config('layouts.layouts'))],
            "seo_title" => ["nullable", "string", "max:255"],
            "seo_description" => ["nullable", "string", "max:255"],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
        ];
    }
    public function beforeSave()
    {
        if (empty($this->slug)) {
            $this->slug = Author::generateSlug($this->name);
        }
        if (empty($this->user_id)) {
            $this->user_id = auth()->user()->id;
        }
    }
    public function statusKey()
    {
        return 'save';
    }

    public function render()
    {
        return view("livewire.dashboard.authors.edit", [
            'previewsThumbnail' => $this->getPreviews('thumbnail'),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
