<?php

namespace App\Livewire\Dashboard\Settings;

use Illuminate\Validation\Rule;

class SinglePostSettings extends SettingsPage
{
    public $post_meta_enabled;
    public $post_meta_author;
    public $post_meta_date;
    public $post_meta_categories;
    public $post_meta_views;
    public $post_meta_comments;

    public $post_tags_enabled;
    public $post_tags_label;

    public $post_share_enabled;
    public $post_share_label;

    public $post_next_prev_enabled;
    public $post_next_label;
    public $post_prev_label;

    public $related_posts_enabled;
    public $related_posts_label;
    public $related_posts_count;
    public $related_posts_query;

    public function title()
    {
        return __('Single post');
    }
    public function rules()
    {
        return [
            'post_meta_enabled' => ['nullable', 'boolean'],
            'post_meta_author' => ['nullable', 'boolean'],
            'post_meta_date' => ['nullable', 'boolean'],
            'post_meta_categories' => ['nullable', 'boolean'],
            'post_meta_views' => ['nullable', 'boolean'],
            'post_meta_comments' => ['nullable', 'boolean'],

            'post_tags_enabled' => ['nullable', 'boolean'],
            'post_tags_label' => ['nullable', 'string', 'max:255'],

            'post_share_enabled' => ['nullable', 'boolean'],
            'post_share_label' => ['nullable', 'string', 'max:255'],

            'post_next_prev_enabled' => ['nullable', 'boolean'],
            'post_next_label' => ['nullable', 'string', 'max:255'],
            'post_prev_label' => ['nullable', 'string', 'max:255'],

            'related_posts_enabled' => ['nullable', 'boolean'],
            'related_posts_label' => ['nullable', 'string', 'max:255'],
            'related_posts_count' => ['nullable', 'numeric'],
            'related_posts_query' => ['nullable', 'string', Rule::in(related_query_values())],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.single-post-settings');
    }
}
