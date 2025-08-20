<?php

namespace Database\Seeders;

use App\Models\Font;
use App\Models\QuoteImage;
use App\Traits\WithRandomCategoryId;
use App\Traits\WithRandomFontId;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class QuoteImageSeeder extends Seeder
{
    use WithRandomCategoryId, WithRandomFontId;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageDir = public_path('assets/images/quote');
        $manager = new ImageManager(new Driver());
        $files = File::files($imageDir);
        foreach ($files as $file) {
            $image = $manager->read($file->getPathname());
            $quoteImage = QuoteImage::create([
                'width' => $image->width(),
                'height' => $image->height(),
                'color' => '#ffffff',
                'border_color' => '#000000',
                'border_width' => 1,
                'min_font' => 10,
                'max_font' => 100,
                'spacing' => 1.7,
                'font_id' => $this->randomFontId(),
                'max_lines' => 7,
                'padding' => 30,
                'align' => 'center',
                'valign' => 'middle',
                'quality' => 75,
                'format' => $file->getExtension(),
            ]);
            $quoteImage->addMedia($file->getPathname())
                ->preservingOriginal()
                ->toMediaCollection('image');
            $categoryId = $this->randomCategoryId();
            if ($categoryId) {
                $quoteImage->assignCategory($categoryId);
            }
        }
    }
}
