<?php

namespace Database\Seeders;

use App\Models\Font;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fontsDir = public_path('assets/fonts');
        $files = File::files($fontsDir);
        foreach ($files as $file) {
            $path = $file->getPathname();
            $fontOb = \FontLib\Font::load($path);
            $font = Font::create([
                'name' => $fontOb->getFontName(),
                'style' => 'normal',
                'weight' => 'normal',
                'display' => 'swap',
                'enabled' => false,
            ]);
            if ($font) {
                $font->addMedia($path)
                    ->preservingOriginal()
                    ->toMediaCollection('font-file');
            }
        }
    }
}
