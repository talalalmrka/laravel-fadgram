<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Post;
use App\Models\Quote;
use App\Models\User;
use App\Traits\WithRandomUserId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    use WithRandomUserId;
    public function getRandomModel()
    {
        return $this->faker->randomElement([
            Post::inRandomOrder()->first(),
            Author::inRandomOrder()->first(),
            Book::inRandomOrder()->first(),
            Quote::inRandomOrder()->first(),
        ]);
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->randomUserId(),
            'model_type' => $this->getRandomModel()->getMorphClass(),
            'model_id' => $this->getRandomModel()->id,
            'rating' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->paragraph(),
            'approved' => $this->faker->boolean(),
        ];
    }
    public function model($model): static
    {
        return $this->state(fn(array $attributes) => [
            'model_type' => $model->getMorphClass(),
            'model_id' => $model->id,
        ]);
    }
}
