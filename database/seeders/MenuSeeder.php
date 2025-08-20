<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //header
        $headerMenu = Menu::create([
            'name' => 'Header menu',
            'position' => 'header',
            'class_name' => 'header-menu',
        ]);
        if ($headerMenu) {
            $headerMenu->items()->create([
                'name' => 'Home',
                'icon' => 'bi-house-fill',
                'type' => 'custom',
                'url' => url('/'),
                'navigate' => false,
            ]);
            $headerMenu->items()->create([
                'name' => 'Gallery',
                'icon' => 'bi-image',
                'type' => 'custom',
                'url' => route('gallery'),
                'navigate' => false,
            ]);
            $headerMenu->items()->create([
                'name' => 'Blog',
                'icon' => 'bi-newspaper',
                'type' => 'custom',
                'url' => url('/blog'),
                'navigate' => false,
            ]);
            $headerMenu->items()->create([
                'name' => 'Quotes',
                'icon' => 'bi-quote',
                'type' => 'custom',
                'url' => url('/quotes'),
                'navigate' => false,
            ]);
            $headerMenu->items()->create([
                'name' => 'Books',
                'icon' => 'bi-book',
                'type' => 'custom',
                'url' => url('/books'),
                'navigate' => false,
            ]);
            $headerMenu->items()->create([
                'name' => 'Authors',
                'icon' => 'bi-people',
                'type' => 'custom',
                'url' => route('authors'),
                'navigate' => false,
            ]);
            $headerMenu->items()->create([
                'name' => 'Categories',
                'icon' => 'bi-folder',
                'type' => 'custom',
                'url' => route('categories'),
                'navigate' => false,
            ]);

            $about = Post::slug('about-us');
            if ($about) {
                $headerMenu->items()->create([
                    'name' => $about->name,
                    'icon' => 'bi-info-circle',
                    'type' => 'page',
                    'page_id' => $about->id,
                    'navigate' => false,
                ]);
            }

            $contact = Post::slug('contact-us');
            if ($contact) {
                $headerMenu->items()->create([
                    'name' => $contact->name,
                    'icon' => 'bi-telephone-fill',
                    'type' => 'page',
                    'page_id' => $contact->id,
                    'navigate' => false,
                ]);
            }

            $privacy = Post::slug('privacy-policy');
            if ($privacy) {
                $headerMenu->items()->create([
                    'name' => $privacy->name,
                    'icon' => 'bi-hammer',
                    'type' => 'page',
                    'page_id' => $privacy->id,
                    'navigate' => false,
                ]);
            }

            $parent = $headerMenu->items()->create([
                'name' => 'Parent',
                'icon' => 'bi-star',
                'type' => 'custom',
                'url' => url('/parent'),
                'navigate' => false,
            ]);
            if ($parent) {
                $sub1 = $headerMenu->items()->create([
                    'parent_id' => $parent->id,
                    'name' => 'Sub 1',
                    'icon' => 'bi-activity',
                    'type' => 'custom',
                    'url' => url('/sub1'),
                    'navigate' => false,
                ]);
                $sub2 = $headerMenu->items()->create([
                    'parent_id' => $parent->id,
                    'name' => 'Sub 2',
                    'icon' => 'bi-airplane',
                    'type' => 'custom',
                    'url' => url('/sub2'),
                    'navigate' => false,
                ]);
            }
        }

        //footer
        $footerMenu = Menu::create([
            'name' => 'Footer menu',
            'position' => 'footer',
            'class_name' => 'footer-menu',
        ]);
        if ($footerMenu) {
            $footerMenu->items()->create([
                'name' => 'Home',
                'icon' => 'bi-house-fill',
                'type' => 'custom',
                'url' => url('/'),
            ]);
            $footerMenu->items()->create([
                'name' => 'Blog',
                'icon' => 'bi-newspaper',
                'type' => 'custom',
                'url' => url('/blog'),
            ]);
        }
        //social
        $socialMenu = Menu::create([
            'name' => 'Social menu',
            'position' => 'social',
            'class_name' => 'social-menu',
        ]);
        if ($socialMenu) {
            $socialMenu->items()->create([
                'icon' => 'bi-facebook',
                'type' => 'custom',
                'url' => 'https://facebook.com/fadgram',
            ]);
            $socialMenu->items()->create([
                'icon' => 'bi-twitter',
                'type' => 'custom',
                'url' => 'https://x.com/fadgram',
            ]);
            $socialMenu->items()->create([
                'icon' => 'bi-telegram',
                'type' => 'custom',
                'url' => 'https://t.me/fadgram',
            ]);
        }
    }
}
