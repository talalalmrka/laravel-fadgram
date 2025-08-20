<?php

namespace App\Livewire;

use App\Models\QuoteImage;
use App\Models\User;
use App\Traits\HasMediaProperties;
use App\Traits\WithImageCrop;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImageCropper extends Component
{
    use HasMediaProperties, WithImageCrop;
    public User $user;
    public $image;
    // public $croppedImage;
    // public $showCrop = false;

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
    public function updatedImage()
    {
        $this->startCrop('image', $this->imageUrl());
    }
    /* public function startCrop()
    {
        if ($this->imageUrl()) {
            $this->dispatch('crop', $this->imageUrl());
        }
    } */
    public function saveCroppedImage()
    {
        $this->validate(['croppedImage' => 'required']);

        // Decode and save the cropped image (base64 string from Cropper.js)
        /*$fileName = 'cropped_' . time() . '.png';
        $image = str_replace('data:image/png;base64,', '', $this->croppedImage);
        $image = str_replace(' ', '+', $image);
        file_put_contents(storage_path('app/public/' . $fileName), base64_decode($image));*/
        // Save the cropped image to the user's media library in the 'croppedimage' collection
        $imageData = $this->croppedImage;
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        $imageData = base64_decode($imageData);

        // Create a temporary file
        $tmpFile = tmpfile();
        $tmpFilePath = stream_get_meta_data($tmpFile)['uri'];
        file_put_contents($tmpFilePath, $imageData);

        // Add to media library (as single file in 'croppedimage' collection)
        $this->user
            ->addMedia($tmpFilePath)
            ->usingFileName('cropped_' . time() . '.png')
            ->toMediaCollection('croppedimage');

        // Close the temp file
        fclose($tmpFile);
        // $this->showCrop = false;
        session()->flash('message', 'Image cropped and uploaded successfully!');
    }
    public function imageUrl()
    {
        return $this->image?->temporaryUrl() ?? $this->user->getFirstMediaUrl('croppedimage');
    }
    public function save()
    {
        $this->validate();
        if ($this->image) {
            $this->user->addMedia($this->pull('image'))->toMediaCollection('croppedimage');
        }
        $this->status(__('Saved'));
    }
    public function render()
    {
        return view('livewire.image-cropper', [
            'previewsImage' => previews($this->image, $this->user->getFirstMedia('croppedimage')),
            'imageUrl' => $this->imageUrl(),
            'showCrop' => $this->showCrop,
        ])->layout('layouts.curve', [
            'title' => __('Image cropper'),
        ]);
    }
}
