<?php

namespace App\Livewire\Dashboard\Media;

use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Show extends Component
{
    #[Locked]
    public Media $media;
    public $show = false;
    public function mount(Media $media)
    {
        $this->media = $media;
    }
    public function close()
    {
        $this->show = false;
    }
    public function download()
    {
        return response()->download($this->media->getPath(), $this->media->file_name);
    }
    public function delete()
    {
        $this->authorize('manage_media', $this->media);
        $this->media->delete();
        $this->close();
        $this->dispatch('saved', 'media');
    }
    #[On('show')]
    public function onShow($model_type, $id)
    {
        if ($model_type === 'media') {
            $media = Media::findOrFail($id);
            $this->mount($media);
            $this->show = true;
        }
    }
    public function render()
    {
        return view('livewire.dashboard.media.show', [
            'title' => __('Media details :name', ['name' => $this->media->name]),
        ]);
    }
}
