<?php

namespace App\Livewire\Dashboard\Media;

use App\Traits\WithEditModelDialog;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'media';
    #[Locked]
    public Media $media;
    public $title = '';
    public $name = '';
    public $collection_name = '';
    public $file_name = '';
    public $file_name_changed = false;
    protected $fillable_data = ['name', 'collection_name', 'file_name'];
    public function mount(Media $media)
    {
        $this->authorize('manage_media', $media);
        $this->media = $media;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'collection_name' => ['required', 'string', Rule::in(media_collection_names($this->media->model()->first()))],
            'file_name' => ['required', 'string', Rule::unique('media', 'file_name')->ignore($this->media)],
        ];
    }
    public function beforeSave()
    {
        $this->file_name_changed = $this->media->isDirty('file_name');
    }
    public function afterSave()
    {
        if ($this->file_name_changed) {
            $this->addSuccess('file_name', __('File name changed'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.media.edit', [
            'collection_options' => media_collection_name_options($this->media->model()->first())
        ]);
    }
}
