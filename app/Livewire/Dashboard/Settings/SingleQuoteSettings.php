<?php

namespace App\Livewire\Dashboard\Settings;

use Illuminate\Validation\Rule;

class SingleQuoteSettings extends SettingsPage
{
    public $quote_books_enabled;
    public $quote_books_label;

    public $quote_meta_enabled;
    public $quote_meta_author;
    public $quote_meta_date;
    public $quote_meta_categories;
    public $quote_meta_views;
    public $quote_meta_comments;

    public $quote_tags_enabled;
    public $quote_tags_label;

    public $quote_share_enabled;
    public $quote_share_label;

    public $quote_next_prev_enabled;
    public $quote_next_label;
    public $quote_prev_label;

    public $related_quotes_enabled;
    public $related_quotes_label;
    public $related_quotes_count;
    public $related_quotes_query;

    public function title()
    {
        return __('Single quote');
    }
    public function rules()
    {
        return [
            'quote_books_enabled' => ['nullable', 'boolean'],
            'quote_books_label' => ['nullable', 'string', 'max:250'],

            'quote_meta_enabled' => ['nullable', 'boolean'],
            'quote_meta_author' => ['nullable', 'boolean'],
            'quote_meta_date' => ['nullable', 'boolean'],
            'quote_meta_categories' => ['nullable', 'boolean'],
            'quote_meta_views' => ['nullable', 'boolean'],
            'quote_meta_comments' => ['nullable', 'boolean'],

            'quote_tags_enabled' => ['nullable', 'boolean'],
            'quote_tags_label' => ['nullable', 'string', 'max:255'],

            'quote_share_enabled' => ['nullable', 'boolean'],
            'quote_share_label' => ['nullable', 'string', 'max:255'],

            'quote_next_prev_enabled' => ['nullable', 'boolean'],
            'quote_next_label' => ['nullable', 'string', 'max:255'],
            'quote_prev_label' => ['nullable', 'string', 'max:255'],

            'related_quotes_enabled' => ['nullable', 'boolean'],
            'related_quotes_label' => ['nullable', 'string', 'max:255'],
            'related_quotes_count' => ['nullable', 'numeric'],
            'related_quotes_query' => ['nullable', 'string', Rule::in(related_query_values())],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.single-quote-settings');
    }
}
