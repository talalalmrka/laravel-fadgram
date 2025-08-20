<?php

namespace App\Traits;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;


trait HasQuotes
{
    /**
     * Get all of the model's comments.
     */
    public function quotes(): MorphToMany
    {
        return $this->morphToMany(Quote::class, 'model', 'model_quotes');
    }

    /**
     * Get only approved comments.
     */
    public function publishedQuotes(): MorphMany
    {
        return $this->quotes()->status('publish');
    }

    public function quotesCount(): int
    {
        return $this->quotes()->count();
    }
    /**
     * Add a quote to the model.
     *
     * @param array $attributes
     * @return \App\Models\Quote
     */
    public function addQuote(array $attributes)
    {
        return $this->quotes()->create($attributes);
    }

    /**
     * Scope the model query to certain quotes only.
     *
     * @param  Builder  $query
     * @param  string|int|array|Quote|Collection  $quotes
     * @param  bool  $without  Determine if the query should exclude these quotes.
     * @return Builder
     */
    public function scopeQuote(Builder $query, $quotes, $without = false): Builder
    {
        $quoteIds = $this->resolveQuoteIds($quotes);

        return $query->whereHas('quotes', function ($query) use ($quoteIds, $without) {
            if ($without) {
                $query->whereNotIn('quotes.id', $quoteIds);
            } else {
                $query->whereIn('quotes.id', $quoteIds);
            }
        });
    }
    /**
     * Resolve quote(s) to IDs for handling quote-related logic.
     *
     * @param  string|int|array|Quote|Collection  $quotes
     * @return array
     */
    public function resolveQuoteIds($quotes): array
    {
        if ($quotes instanceof Collection) {
            return $quotes->pluck('id')->all();
        }

        if ($quotes instanceof Quote) {
            return [$quotes->id];
        }

        if (is_array($quotes)) {
            $quotes = array_filter(Arr::flatten($quotes));
            return Quote::whereIn('slug', $quotes)
                ->orWhereIn('id', $quotes)
                ->pluck('id')
                ->all();
        }

        return [Quote::where('slug', $quotes)->orWhere('id', $quotes)->value('id')];
    }

    /**
     * Resolve a single quote to its ID.
     *
     * @param  string|int|Quote  $quote
     * @return int|null
     */
    protected function resolveQuoteId($quote): ?int
    {
        if ($quote instanceof Quote) {
            return $quote->id;
        }

        if (is_numeric($quote)) {
            return $quote;
        }

        return Quote::where('slug', $quote)->value('id');
    }
    /**
     * Assign the given quotes to the model.
     *
     * @param  string|int|array|Quote|Collection  ...$quotes
     * @return $this
     */
    public function assignQuote(...$quotes)
    {
        $quoteIds = $this->resolveQuoteIds($quotes);
        $this->quotes()->syncWithoutDetaching($quoteIds);

        return $this;
    }

    /**
     * Revoke the given quote from the model.
     *
     * @param  string|int|Quote  $quote
     * @return $this
     */
    public function removeQuote($quote)
    {
        $quoteId = $this->resolveQuoteId($quote);
        if ($quoteId) {
            $this->quotes()->detach($quoteId);
        }
        return $this;
    }

    /**
     * Sync the given quotes, removing any that are not in the list.
     *
     * @param  string|int|array|Quote|Collection  ...$quotes
     * @return $this
     */
    public function syncQuotes(...$quotes)
    {
        $quoteIds = $this->resolveQuoteIds($quotes);
        $this->quotes()->sync($quoteIds);
        return $this;
    }

    /**
     * Determine if the model has (one of) the given quotes.
     *
     * @param  string|int|Quote  $quote
     * @return bool
     */
    public function hasQuote($quote): bool
    {
        $quoteId = $this->resolveQuoteId($quote);

        return $quoteId ? $this->quotes->contains('id', $quoteId) : false;
    }

    /**
     * Determine if the model has any of the given quotes.
     *
     * @param  array|Collection  $quotes
     * @return bool
     */
    public function hasAnyQuote(...$quotes): bool
    {
        foreach ($quotes as $quote) {
            if ($this->hasQuote($quote)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the model has all of the given quotes.
     *
     * @param  array|Collection  $quotes
     * @return bool
     */
    public function hasAllQuotes($quotes): bool
    {
        foreach ($quotes as $quote) {
            if (!$this->hasQuote($quote)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the names of all assigned quotes.
     *
     * @return Collection
     */
    public function getQuoteNames(): Collection
    {
        return $this->quotes->pluck('name');
    }

    /**
     * Get the slugs of the quotes assigned to the model.
     */
    public function getQuoteSlugs(): Collection
    {
        return $this->quotes->pluck('slug');
    }

    /**
     * Get the ids of the quotes assigned to the model.
     */
    public function getQuoteIds(): Collection
    {
        return $this->quotes->pluck('id');
    }
}
