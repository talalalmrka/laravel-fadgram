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
            Quote::factory(20)
                ->status('publish')
                ->withCategories($book->getCategoryIds()->toArray())
                /* ->withMetas([
                    'views' => rand(1, 1000)
                ]) */
                ->create()
                ->each(function (Quote $quote) use ($book) {
                    $quote->updateMeta('views', rand(1, 10000));
                    $book->assignQuote($quote);
                });
        }
    }
}
