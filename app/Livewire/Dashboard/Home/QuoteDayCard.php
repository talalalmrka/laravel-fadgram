<?php

namespace App\Livewire\Dashboard\Home;

use App\Models\Category;
use App\Models\QuoteDay;
use App\Traits\WithToast;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\NotIn;
use Livewire\Component;

class QuoteDayCard extends Component
{
    use WithToast;
    public $category_id;
    public $quote_id;
    public $today;
    public $showAdd = false;
    public function mount()
    {
        $this->today = Carbon::today();
    }
    public function rules()
    {
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('type', 'category'), Rule::unique('quote_days')->where(function ($query) {
                return $query->where('category_id', $this->category_id)
                    ->where('day', $this->today);
            })],
            'quote_id' => ['required', 'integer', Rule::exists('quotes', 'id')->where('status', 'publish')],
            'today' => ['required', 'date', Rule::unique('quote_days')->where(function ($query) {
                return $query->where('category_id', $this->category_id)
                    ->where('quote_id', $this->quote_id);
            })]
        ];
    }

    public function quoteDays()
    {
        return QuoteDay::where('day', $this->today)->get();
    }
    public function notIn()
    {
        return $this->quoteDays()->map(fn(QuoteDay $quoteDay) => $quoteDay->category_id)->toArray();
    }
    public function add()
    {
        $this->showAdd = true;
    }
    public function save()
    {
        $this->validate();
        $create = QuoteDay::create([
            'user_id' => current_user_id(),
            'quote_id' => $this->pull('quote_id'),
            'category_id' => $this->pull('category_id'),
            'day' => $this->today,
        ]);
        if ($create) {
            $this->status(__('Added'));
            $this->showAdd = false;
        } else {
            $this->addError('status', __('Failed!'));
        }
    }

    public function delete(QuoteDay $quoteDay)
    {
        $quoteDay->delete();
    }
    public function categoryOptions()
    {
        return Category::hasQuotes()->get()->map(fn(Category $category) => ([
            'label' => "$category->name ({$category->quotes_count})",
            'value' => $category->id,
        ]))->toArray();
    }
    public function render()
    {
        return view('livewire.dashboard.home.quote-day-card', [
            'quoteDays' => $this->quoteDays(),
            'notIn' => $this->notIn(),
            'today_formatted' => date_format($this->today, app_date_format()),
            'category_options' => $this->categoryOptions(),
        ]);
    }
}
