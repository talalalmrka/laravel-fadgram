<?php

namespace App\Livewire\Dashboard\Settings;

use App\Rules\ValidSort;
use Illuminate\Validation\Rule;

class SingleBookSettings extends SettingsPage
{
    public $book_share_enabled;
    public $book_share_label;

    public $book_display_quotes;
    public $book_quotes_section_title;
    public $book_add_quote;
    public $book_quote_approve_required;
    public $book_quote_approve_previous;
    public $book_quotes_per_page;
    public $book_quotes_sort;

    public $book_next_prev_enabled;
    public $book_next_label;
    public $book_prev_label;

    public $related_books_enabled;
    public $related_books_label;
    public $related_books_count;
    public $related_books_query;

    public function title()
    {
        return __('Single book');
    }
    public function rules()
    {
        return [
            'book_share_enabled' => ['nullable', 'boolean'],
            'book_share_label' => ['nullable', 'string', 'max:255'],

            'book_display_quotes' => ['nullable', 'boolean'],
            'book_quotes_section_title' => ['nullable', 'string', 'max:255'],
            'book_add_quote' => ['nullable', 'boolean'],
            'book_quote_approve_required' => ['nullable', 'boolean'],
            'book_quote_approve_previous' => ['nullable', 'boolean'],
            'book_quotes_per_page' => ['nullable', 'numeric'],
            'book_quotes_sort' => ['required', new ValidSort],

            'book_next_prev_enabled' => ['nullable', 'boolean'],
            'book_next_label' => ['nullable', 'string', 'max:255'],
            'book_prev_label' => ['nullable', 'string', 'max:255'],

            'related_books_enabled' => ['nullable', 'boolean'],
            'related_books_label' => ['nullable', 'string', 'max:255'],
            'related_books_count' => ['nullable', 'numeric'],
            'related_books_query' => ['nullable', 'string', Rule::in(related_query_values())],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.single-book-settings');
    }
}
