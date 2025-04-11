<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Page;
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
            ]);
            $headerMenu->items()->create([
                'name' => 'Blog',
                'icon' => 'bi-newspaper',
                'type' => 'custom',
                'url' => url('/blog'),
            ]);

            $about = Page::slug('about-us');
            if ($about) {
                $headerMenu->items()->create([
                    'name' => $about->name,
                    'icon' => 'bi-info-circle',
                    'type' => 'page',
                    'page_id' => $about->id,
                ]);
            }

            $contact = Page::slug('contact-us');
            if ($contact) {
                $headerMenu->items()->create([
                    'name' => $contact->name,
                    'icon' => 'bi-telephone-fill',
                    'type' => 'page',
                    'page_id' => $contact->id,
                ]);
            }

            $privacy = Page::slug('privacy-policy');
            if ($privacy) {
                $headerMenu->items()->create([
                    'name' => $privacy->name,
                    'icon' => 'bi-hammer',
                    'type' => 'page',
                    'page_id' => $privacy->id,
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
