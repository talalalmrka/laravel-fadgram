<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\HasMediaProperties;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Cropper extends Component
{
    use HasMediaProperties;
    public User $user;
    public TemporaryUploadedFile | null $image = null;
    public $croppedImage;
    public function mount()
    {
        $this->user = current_user();
    }
    public function rules()
    {
        return [
            'image' => ['nullable', 'image', 'max:10240'],
        ];
    }
    public function save()
    {
        $this->validate();
        if ($this->image) {
            $this->user
                ->addMedia($this->image)
                ->toMediaCollection('croppedimage');
        }
    }
    public function render()
    {
        return view('livewire.cropper', [
            'imageUrl' => $this->image?->temporaryUrl() ?? $this->user->getFirstMediaUrl('croppedimage'),
            'previewsImage' => previews($this->image, $this->user->getFirstMedia('croppedimage')),
        ])->layout('layouts.curve', [
            'title' => __('Image cropper'),
        ]);
    }
}
