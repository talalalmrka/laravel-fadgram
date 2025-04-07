<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->create([
            'user_id' => 1,
            'name' => 'Fadgram laravel starter kit',
            'slug' => Post::generateSlug('Fadgram laravel starter kit'),
            'type' => 'post',
            'status' => 'publish',
            'content' => '<h1>Fadgram Laravel Starter Kit</h1>
                  <p>Fadgram Laravel Starter Kit is a comprehensive starter template for building Laravel applications. It includes pre-configured authentication, Tailwind CSS integration, and a set of reusable components to kickstart your development process.</p>
                  <h2>Features</h2>
                  <ul>
                      <li>Pre-configured authentication system</li>
                      <li>Tailwind CSS integration</li>
                      <li>Reusable components</li>
                      <li>Scalable architecture</li>
                  </ul>
                  <h2>Installation</h2>
                  <pre><code>git clone https://github.com/your-repo/fadgram-laravel-starter-kit.git
    cd fadgram-laravel-starter-kit
    composer install
    npm install
    npm run dev
    php artisan migrate
    </code></pre>
                  <h2>Usage</h2>
                  <p>Start your development server:</p>
                  <pre><code>php artisan serve</code></pre>
                  <p>Visit <a href="http://localhost:8000">http://localhost:8000</a> to view your application.</p>
                  <h2>Contributing</h2>
                  <p>Contributions are welcome! Please fork this repository and submit a pull request.</p>
                  <h2>License</h2>
                  <p>This project is open-source and available under the <a href="https://opensource.org/licenses/MIT">MIT License</a>.</p>',
        ])->each(function (Post $post) {
            $post->addMedia(public_path('assets/img/laravel-fadgram.png'))->preservingOriginal()->toMediaCollection($post->thumbnailCollection());
        });

        Post::factory()->create([
            'user_id' => 1,
            'name' => 'Fadgram UI',
            'slug' => Post::generateSlug('Fadgram UI'),
            'type' => 'post',
            'status' => 'publish',
            'content' => '<p style="box-sizing: border-box; color: rgb(51, 51, 51); font-size: var(--readme-font-size); margin-top: 0px; margin-bottom: 16px; line-height: 1.65; letter-spacing: 0.1px; font-family: &quot;Source Sans Pro&quot;, &quot;Lucida Grande&quot;, sans-serif; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;">Fadgram UI is a Tailwind CSS plugin that provides a set of custom utility classes to enhance your web development experience. This plugin is designed to work seamlessly with Tailwind CSS, allowing you to quickly and easily style your web applications.<span>&nbsp;</span><a target="_blank" rel="noopener noreferrer" href="https://github.com/user-attachments/assets/f5eb0b42-ad31-46de-9062-a8e2bc6100a3" style="box-sizing: border-box; background-color: transparent; color: var(--wombat-red); text-decoration: none; font-size: 1em; font-weight: 600;"><img src="https://github.com/user-attachments/assets/f5eb0b42-ad31-46de-9062-a8e2bc6100a3" alt="FadgramUI" style="box-sizing: border-box; border-style: none; max-width: 100%;"></a></p>',
        ])->each(function (Post $post) {
            $post->addMedia(public_path('assets/img/fadgram-ui.png'))->preservingOriginal()->toMediaCollection($post->thumbnailCollection());
        });
        //Post::factory(28)->create();
    }
}
