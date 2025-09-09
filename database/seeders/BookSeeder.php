<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory(20)->status('publish')->create()->each(function (Book $book) {
            $book->updateMeta('views', rand(1, 10000));
            $book->updateMeta('downloads', rand(1, 10000));
        });
    }
}
