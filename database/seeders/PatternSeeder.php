<?php

namespace Database\Seeders;

use App\Models\Pattern;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/patterns.json');
        if (File::exists($path)) {
            $json = file_get_contents($path);
            if (is_json($json)) {
                $patterns = json_decode($json, true);
                foreach ($patterns as $pattern) {
                    // $block = data_get($pattern, 'block', []);
                    // $pattern['block'] = json_encode($block);
                    Pattern::create($pattern);
                }
            }
        }
    }
}
