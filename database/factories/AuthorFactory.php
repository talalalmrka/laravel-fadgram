<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Comment;
use App\Traits\WithRandomUserId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    use WithRandomUserId;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        return [
            'name' => $name,
            'slug' => Author::generateSlug($name),
            'status' => $this->faker->randomElement(status_values()),
            'content' => $this->faker->paragraphs(2, true),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Author $author) {});
    }
}
