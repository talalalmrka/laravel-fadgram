<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Traits\WithRandomUserId;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    use WithRandomUserId;
    public function randomCategoryId()
    {
        $category = Category::where('type', 'category')->inRandomOrder()->first();
        return $category?->id;
    }
    public function randomTagId()
    {
        $tag = Category::where('type', 'tag')->inRandomOrder()->first();
        return $tag?->id;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence(2, true);
        return [
            'user_id' => $this->randomUserId(),
            'name' => $name,
            'slug' => Post::generateSlug($name),
            'type' => 'post',
            'status' => $this->faker->randomElement(['draft', 'publish', 'trash']),
            'content' => $this->faker->paragraphs(5, true),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $post->assignCategory($this->randomCategoryId());
            $post->assignTag($this->randomTagId());
        });
    }
    /**
     * Set type
     */
    public function type(string $type): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }
    /**
     * Set type
     */
    public function status(string $status): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status,
        ]);
    }
}
