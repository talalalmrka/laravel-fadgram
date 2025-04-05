<?php

namespace App\Livewire\Dashboard\Categories;

use App\Models\Category;
use App\Traits\WithEditModelDialog;
use Livewire\Attributes\Locked;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'category';
    #[Locked]
    public Category $category;
    public $title = '';
    public $name = '';
    public $slug = null;
    public $type = 'category';
    public $parent_id = null;
    public $description = '';
    public $thumbnail;
    protected $fillable_data = ['name', 'slug', 'type', 'parent_id', 'description'];
    protected $fillable_meta = [];
    protected $fillable_media = ['thumbnail'];
    public function mount(Category $category)
    {
        $this->authorize('manage_categories');
        $this->category = $category;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($this->category)],
            'type' => ['required', 'string', Rule::in(['category', 'tag'])],
            'parent_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'description' => ['nullable', 'string', 'max:1024'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ];
    }
    public function beforeSave()
    {
        $this->type = 'category';
        if (empty($this->slug)) {
            $this->slug = Category::generateSlug($this->name);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.categories.edit', [
            'previewsThumbnail' => previews($this->category->getMedia('thumbnail'), $this->thumbnail),
        ]);
    }
}
