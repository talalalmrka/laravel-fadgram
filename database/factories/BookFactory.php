<?php

namespace Database\Factories;

use App\Models\Book;

use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Quote;
use App\Models\User;
use App\Traits\WithRandomUserId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
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
    public function randomAuthorId()
    {
        $author = Author::inRandomOrder()->first();
        return $author?->id;
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
            'slug' => Book::generateSlug($name),
            'status' => $this->faker->randomElement(['draft', 'publish', 'trash']),
            'content' => $this->faker->paragraphs(5, true),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $book->assignCategory($this->randomCategoryId());
            $book->assignTag($this->randomTagId());
            $author_id = $this->randomAuthorId();
            if ($author_id) {
                $book->assignAuthor($author_id);
            }
        });
    }
}
