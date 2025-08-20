<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Post;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        foreach ($books as $book) {
            Quote::factory(5)->status('publish')->withCategories($book->getCategoryIds()->toArray())->create()->each(function (Quote $quote) use ($book) {
                $book->assignQuote($quote);
            });
        }
    }
}
