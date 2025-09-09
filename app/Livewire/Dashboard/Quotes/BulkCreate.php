<?php

namespace App\Livewire\Dashboard\Quotes;

use App\Models\Quote;
use App\Traits\WithToast;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BulkCreate extends Component
{
    use WithToast;
    public $author_id;
    public $user_id;
    public $categories = [];
    public $quotes;
    public $count = 5;
    public function mount()
    {
        $this->authorize('manage_quotes');
        $this->user_id = current_user_id();
        $this->initQuotes();
    }
    public function initQuotes()
    {
        $this->quotes = arr_map(range(0, $this->getCount()), function ($i) {
            $number = $i + 1;
            return [
                'name' => '',
                'slug' => '',
                // 'content' => "quote number $number",
                'content' => "",
            ];
        });
    }
    public function getCount(): int
    {
        $count = intval($this->count);
        if (empty($count)) {
            return 1;
        } else {
            return $count - 1;
        }
    }
    public function rules()
    {
        return [
            'count' => ['required', 'numeric', 'min:1'],
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'author_id' => ['nullable', 'integer', Rule::exists('authors', 'id')],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
            'quotes' => ['required', 'array'],
            'quotes.*.name' => ['nullable', 'string', 'max:255'],
            'quotes.*.slug' => ['nullable', 'string', 'max:255', 'unique:quotes,slug'],
            'quotes.*.content' => ['nullable', 'string', 'max:1000'],
        ];
    }
    public function updatedCount()
    {
        $this->quotes = arr_map(range(0, $this->getCount()), function ($i) {
            $number = $i + 1;
            return data_get($this->quotes, $i, [
                'name' => '',
                'slug' => '',
                // 'content' => "quote number $number",
                'content' => "",
            ]);
        });
    }

    public function add()
    {
        $this->count++;
        $number = $this->count + 1;
        $this->quotes[] = [
            'name' => '',
            'slug' => '',
            // 'content' => "quote number $number",
            'content' => "",
        ];
    }
    public function delete($index)
    {
        array_splice($this->quotes, $index, 1);
        $this->count = sizeof($this->quotes);
    }
    public function save()
    {
        $this->validate();
        $quotes = collect($this->quotes)->filter(fn($q) => !empty(data_get($q, 'content')))->map(function ($quote) {
            $content = data_get($quote, 'content');
            $name = !empty(data_get($quote, 'name')) ? data_get($quote, 'name') : substr($content, 0, 10);
            $slug = data_get($quote, 'slug');
            return [
                'user_id' => $this->user_id,
                'name' => $name,
                'slug' => $slug,
                'content' => $content,
            ];
        });
        $count = 0;
        $quotes->each(function ($quoteData) use (&$count) {
            $quote = Quote::create($quoteData);
            if ($quote) {
                if ($this->author_id) {
                    $quote->assignAuthor($this->author_id);
                }
                if (!empty($this->categories)) {
                    $quote->syncCategories($this->categories);
                }
                $count++;
            }
        });
        if ($count) {
            $this->addSuccess('save', __(':count quotes inserted successfully', ['count' => $count]));
            $this->initQuotes();
        } else {
            $this->addError('save', __('Nothing to save'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.quotes.bulk-create')->layout('layouts.dashboard', [
            'title' => 'Create multi quotes'
        ]);
    }
}
