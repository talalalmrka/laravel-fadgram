<?php

namespace Database\Seeders;

use App\Models\Menu;
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
        }

        //footer
        $headerMenu = Menu::create([
            'name' => 'Footer menu',
            'position' => 'footer',
            'class_name' => 'footer-menu',
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
        }
        //social
        $headerMenu = Menu::create([
            'name' => 'Social menu',
            'position' => 'social',
            'class_name' => 'social-menu',
        ]);
        if ($headerMenu) {
            $headerMenu->items()->create([
                'icon' => 'bi-facebook',
                'type' => 'custom',
                'url' => 'https://facebook.com/fadgram',
            ]);
            $headerMenu->items()->create([
                'icon' => 'bi-twitter',
                'type' => 'custom',
                'url' => 'https://x.com/fadgram',
            ]);
            $headerMenu->items()->create([
                'icon' => 'bi-telegram',
                'type' => 'custom',
                'url' => 'https://t.me/fadgram',
            ]);
        }
    }
}
