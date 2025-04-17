<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['page', 'post', 'category', 'custom']);
        $page_id = $type === 'page' ? Page::inRandomOrder()->first()?->id : null;
        $post_id = $type === 'post' ? Post::inRandomOrder()->first()?->id : null;
        $category_id = $type === 'category' ? Category::inRandomOrder()->first()?->id : null;
        $menu_id = Menu::inRandomOrder()->first()?->id;
        $random_parent_id = MenuItem::inRandomOrder()->first()?->id;
        $parent_id = $this->faker->randomElement([null, $random_parent_id]);
        return [
            'menu_id' => $menu_id,
            'parent_id' => $parent_id,
            'name' =>  $this->faker->sentence(2),
            'icon' => $this->faker->optional(0.3)->randomElement(['fa-home', 'fa-user', 'fa-cog', 'fa-envelope']),
            'order' => null, // Let model handle ordering
            'type' => $type,
            'page_id' => $page_id,
            'post_id' => $post_id,
            'category_id' => $category_id,
            'url' => $type === 'custom' ? $this->faker->url() : null,
            'class_name' => $this->faker->optional(0.2)->word,
            'navigate' => $this->faker->boolean(80),
            'new_tab' => $this->faker->boolean(30),
        ];
    }
    public function withParent()
    {
        return $this->state(function (array $attributes) {
            $parent = MenuItem::factory()->create();

            return [
                'parent_id' => $parent->id,
                'menu_id' => $parent->menu_id,
            ];
        });
    }

    public function forMenu($menu)
    {
        return $this->state(function (array $attributes) use ($menu) {
            return ['menu_id' => $menu instanceof Menu ? $menu->id : $menu];
        });
    }

    public function withSpecificOrder($order)
    {
        return $this->state(['order' => $order]);
    }

    /*public function configure()
    {
        return $this->afterCreating(function (MenuItem $menuItem) {
            // Ensure relational consistency
            if ($menuItem->parent_id) {
                $menuItem->menu_id = $menuItem->parent->menu_id;
                $menuItem->save();
            }
        });
    }*/
}
