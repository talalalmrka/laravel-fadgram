<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'user_id' => 1,
            'name' => 'About us',
            'content' => "<p>Welcome to our platform. We are dedicated to providing the best service to our customers. Learn more about our values, mission, and the story behind our store.</p>",
            'status' => 'publish',
        ]);
        Page::create([
            'user_id' => 1,
            'name' => "Privacy policy",
            'content' => "<p>Your privacy is important to us at our platform. We are committed to protecting your personal data and respecting your privacy.</p>",
            'status' => 'publish',
        ]);
        Page::create([
            'user_id' => 1,
            'name' => "Contact us",
            'content' => '<p>You can contact us on email <a href="mailto:contact@example.com">contact@example.com</a>.</p>',
            'status' => 'publish',
        ]);
    }
}
