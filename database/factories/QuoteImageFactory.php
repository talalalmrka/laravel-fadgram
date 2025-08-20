<?php

namespace Database\Factories;

use App\Traits\WithRandomCategoryId;
use App\Traits\WithRandomUserId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuoteImage>
 */
class QuoteImageFactory extends Factory
{
    use WithRandomUserId,
        WithRandomCategoryId;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
