<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // authors
        Author::all()->each(fn(Author $author) => Comment::factory(5)->model($author)->create());

        // posts
        Post::all()->each(fn(Post $post) => Comment::factory(5)->model($post)->create());

        // quotes
        Quote::all()->each(fn(Quote $quote) => Comment::factory(5)->model($quote)->create());

        // books
        Book::all()->each(fn(Book $book) => Comment::factory(5)->model($book)->create());
    }
}
