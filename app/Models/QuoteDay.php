<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteDay extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteDayFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'quote_id',
        'category_id',
        'day',
    ];
    protected $with = [
        'quote',
        'category',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Quote
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }
    public function quoteThumbnailUrl($conversion = '')
    {
        $this->quote?->getThumbnailUrl($conversion);
    }
    public function quoteName(): Attribute
    {
        return Attribute::get(fn() => $this->quote?->name);
    }
    public function quoteContent(): Attribute
    {
        return Attribute::get(fn() => $this->quote?->content);
    }
    public function quotePermalink(): Attribute
    {
        return Attribute::get(fn() => $this->quote?->permalink);
    }
    public function quoteAuthor(): Attribute
    {
        return Attribute::get(fn() => $this->quote?->author);
    }
    public function quoteAuthorId(): Attribute
    {
        return Attribute::get(fn() => $this->quote_author?->id);
    }
    public function quoteAuthorName(): Attribute
    {
        return Attribute::get(fn() => $this->quote_author?->name);
    }
    public function quoteAuthorPermalink(): Attribute
    {
        return Attribute::get(fn() => $this->quote_author?->permalink);
    }

    // Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryName(): Attribute
    {
        return Attribute::get(fn() => $this->category?->name);
    }
    public function categoryPermalink(): Attribute
    {
        return Attribute::get(fn() => $this->category?->permalink);
    }


    public function scopeForDay($query, $day)
    {
        return $query->where('day', $day);
    }
    public function scopeCategory($query, $category)
    {
        return $query->whereHas('quote', function ($q) use ($category) {
            $q->category($category);
        });
    }
}
