<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $position = $this->faker->randomElement(['header', 'footer', 'social']);
        $name = ucfirst($position) . " menu";
        return [
            'name' => $name,
            'position' => $position,
            'class_name' => "$position-menu",
        ];
    }
}
