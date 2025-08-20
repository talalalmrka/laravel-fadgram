<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\QuoteImage;
use App\Traits\WithRandomAuthorId;
use App\Traits\WithRandomCategoryId;
use App\Traits\WithRandomQuoteImageId;
use App\Traits\WithRandomTagId;
use App\Traits\WithRandomUserId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    use WithRandomUserId,
        WithRandomCategoryId,
        WithRandomTagId,
        WithRandomAuthorId,
        WithRandomQuoteImageId;
    public $categories = null;
    public function withCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        return [
            'user_id' => $this->randomUserId(),
            'quote_image_id' => $this->randomQuoteImageId(),
            'name' => $name,
            'slug' => Quote::generateSlug($name),
            'status' => $this->faker->randomElement(status_values()),
            'content' => $this->faker->paragraph(1)
        ];
    }
    public function status(string $status): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status,
        ]);
    }
    public function configure()
    {
        return $this->afterCreating(function (Quote $quote) {
            if ($this->categories) {
                $quote->assignCategory($this->categories);
            } else {
                $quote->assignCategory($this->randomCategoryId());
            }
            $quote->assignTag($this->randomTagId());
            $author_id = $this->randomAuthorId();
            if ($author_id) {
                $quote->assignAuthor($author_id);
            }

            $quoteImages = QuoteImage::inRandomOrder()->take(5)->get();
            if ($quoteImages) {
                $quote->syncQuoteImages($quoteImages);
            }
        });
    }
}
