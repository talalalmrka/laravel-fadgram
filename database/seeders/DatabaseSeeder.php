<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            FontSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            PostSeeder::class,
            PageSeeder::class,
            BookSeeder::class,
            QuoteImageSeeder::class,
            QuoteSeeder::class,
            MenuSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
