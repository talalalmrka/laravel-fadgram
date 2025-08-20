<?php

namespace App\Livewire\Dashboard\Settings;

use Exception;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ArchiveSettings extends SettingsPage
{
    public $excerpt_enabled;
    public $excerpt_length;
    public $excerpt_more;
    public $excerpt_preverse_words;
    public $share_enabled;
    public $share_label;
    public $share_buttons = [];
    public function title()
    {
        return __('Archive settings');
    }
    public function afterFill()
    {
        if (!is_array($this->share_buttons)) {
            $this->share_buttons = [];
        }
    }
    public function rules()
    {
        return [
            'excerpt_enabled' => ['nullable', 'boolean'],
            'excerpt_length' => ['nullable', 'numeric'],
            'excerpt_more' => ['nullable', 'string', 'max:255'],
            'excerpt_preverse_words' => ['nullable', 'boolean'],
            'share_enabled' => ['nullable', 'boolean'],
            'share_label' => ['nullable', 'string', 'max:255'],
            'share_buttons' => ['nullable', 'array'],
            'share_buttons.*.enabled' => ['nullable', 'boolean'],
            'share_buttons.*.name' => ['nullable', 'string', 'max:255'],
            'share_buttons.*.icon' => ['nullable', 'string', 'max:255'],
            'share_buttons.*.url' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function deleteShareButton($index)
    {
        try {
            unset($this->share_buttons[$index]);
            $this->toastSuccess(__('Deleted'));
        } catch (Exception $e) {
            $message = env('APP_DEBUG', false) ? __('Delete failed: :message', ['message' => $e->getMessage()]) : __('Delete failed!');
            $this->toastError($message);
        }
    }
    public function addShareButton()
    {
        try {
            $this->share_buttons[] = [
                'enabled' => false,
                'icon' => '',
                'name' => '',
                'url' => '',
            ];
            $this->toastSuccess(__('Added'));
        } catch (Exception $e) {
            $message = env('APP_DEBUG', false) ? __('Add failed: :message', ['message' => $e->getMessage()]) : __('Add failed!');
            $this->toastError($message);
        }
    }
    public function view()
    {
        return view('livewire.dashboard.settings.archive-settings');
    }
}
