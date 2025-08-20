<?php

namespace App\Livewire\Dashboard\Settings;

use Illuminate\Validation\Rule;
use Livewire\Component;

class DiscussionSettings extends SettingsPage
{
    public $comments_enabled;
    public $comments_login_required;
    public $comments_name_email_required;
    public $comments_auto_close;
    public $comments_auto_close_days;

    public $comments_nested_enabled;
    public $comments_nested_level;

    public $comments_per_page;
    public $comments_sort;

    public $comments_approve_required;
    public $comments_approve_previous;

    public $comments_avatar_enabled;

    public $comments_hold_links;
    public $comments_hold_words;
    public $comments_black_list;


    public function title()
    {
        return __('Discussion settings');
    }
    public function rules()
    {
        return [
            'comments_enabled' => ['nullable', 'boolean'],
            'comments_login_required' => ['nullable', 'boolean'],
            'comments_name_email_required' => ['nullable', 'boolean'],
            'comments_auto_close' => ['nullable', 'boolean'],
            'comments_auto_close_days' => ['required', 'numeric', 'max:10000'],
            'comments_nested_enabled' => ['nullable', 'boolean'],
            'comments_nested_level' => ['required', 'numeric', 'min:2', 'max:10'],
            'comments_per_page' => ['required', 'numeric', 'min:1', 'max:100'],
            'comments_sort' => ['required', 'string', Rule::in(comments_sort_values())],
            'comments_approve_required' => ['nullable', 'boolean'],
            'comments_approve_previous' => ['nullable', 'boolean'],
            'comments_avatar_enabled' => ['nullable', 'boolean'],
            'comments_hold_links' => ['nullable', 'numeric', 'max:100'],
            'comments_hold_words' => ['nullable', 'string', 'max:2000'],
            'comments_black_list' => ['nullable', 'string', 'max:2000'],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.discussion-settings');
    }
}
