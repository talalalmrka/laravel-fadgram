<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class PageSeeder extends Seeder
{
    public static function homeBlocks()
    {
        $path = database_path('seeders/homeblocks.json');
        if (File::exists($path)) {
            $json = file_get_contents($path);
            if (is_json($json)) {
                return json_decode($json, true);
            }
        }
        return [];
    }

    public static function createHome(): Post
    {
        $admin = UserSeeder::createAdmin();
        $home = Post::type('page')->slug('home')->first();
        if (!$home) {
            $home = Post::create([
                'user_id' => $admin->id,
                'type' => 'page',
                'name' => 'Home',
                'content' => "<p>Welcome to our Homepage</p>",
                'status' => 'publish',
            ]);
            if ($home) {
                $home->saveMetas([
                    'template' => 'default',
                    'builder_enabled' => 1,
                ]);
                $home->saveBlocks(self::homeBlocks());
            }
        }
        return $home;
    }

    public static function createBlog(): Post
    {
        $admin = UserSeeder::createAdmin();
        $blog = Post::type('page')->slug('blog')->first();
        if (!$blog) {
            $blog = Post::create([
                'user_id' => $admin->id,
                'type' => 'page',
                'name' => 'Blog',
                'content' => "",
                'status' => 'publish',
            ]);
            if ($blog) {
                $blog->saveMetas([
                    'template' => 'default',
                ]);
            }
        }
        return $blog;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::createHome();
        self::createBlog();
        Post::create([
            'user_id' => 1,
            'type' => 'page',
            'name' => 'About us',
            'content' => "<p>Welcome to our platform. We are dedicated to providing the best service to our customers. Learn more about our values, mission, and the story behind our store.</p>",
            'status' => 'publish',
        ]);
        Post::create([
            'user_id' => 1,
            'type' => 'page',
            'name' => "Privacy policy",
            'content' => "<p>Your privacy is important to us at our platform. We are committed to protecting your personal data and respecting your privacy.</p>",
            'status' => 'publish',
        ]);
        Post::create([
            'user_id' => 1,
            'type' => 'page',
            'name' => "Contact us",
            'content' => '<p>You can contact us on email <a href="mailto:contact@example.com">contact@example.com</a>.</p>',
            'status' => 'publish',
        ]);
    }
}
