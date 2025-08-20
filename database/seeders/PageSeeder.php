<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PageSeeder extends Seeder
{
    public function homePage()
    {
        $admin = \App\Models\User::role('admin')->first();
        return [
            'user_id' => $admin->id,
            'type' => 'page',
            'name' => 'Home',
            'content' => "<p>Welcome to our Homepage</p>",
            'status' => 'publish',
            'meta' => [
                'template' => 'default',
                'builder_enabled' => 1,
            ],
            'blocks' => [
                [
                    'type' => 'container',
                    'attributes' => [
                        'fullWidth' => false,
                        'className' => 'bg-gray-100 border-dotted-red p-4',
                    ],
                    'children' => [
                        [
                            'type' => 'container',
                            'attributes' => [
                                'fullWidth' => false,
                                'className' => 'bg-gray-100 border-dotted-red p-4',
                            ],
                        ],
                        [
                            'type' => 'container',
                            'attributes' => [
                                'fullWidth' => false,
                                'className' => 'bg-gray-100 border-dotted-red p-4',
                            ],
                        ],
                    ],

                ],
            ],
            /*,
            'blocks' => [
                [
                    'type' => 'hero',
                    'theme' => 'dark',
                    'title' => 'Hero Title',
                    'subtitle' => 'Hero subtitle',
                    'text' => null,
                    'color' => 'white',
                    'bgcolor' => 'primary',
                    'image' => 'http://localhost:8000/uploads/51/flowers.jpg',
                    'className' => null,
                    'children' => [
                        [
                            'type' => 'button',
                            'label' => 'Action 1',
                            'color' => 'primary',
                            'outline' => false,
                            'gradient' => false,
                            'pill' => true,
                            'size' => 'lg',
                            'className' => null,
                            'id' => 'block-689b54e13a05a'
                        ],
                        [
                            'type' => 'button',
                            'label' => 'Action 2',
                            'color' => 'white',
                            'outline' => true,
                            'gradient' => false,
                            'pill' => true,
                            'size' => 'lg',
                            'className' => null,
                            'id' => 'block-689b54e13a05c'
                        ]
                    ],
                    'id' => 'block-689b54e13a054'
                ],
                [
                    'type' => 'quotes_grid',
                    'title' => 'Latest quotes',
                    'show_title' => true,
                    'categories' => [],
                    'tags' => [],
                    'users' => [],
                    'authors' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => 'mt-6',
                    'id' => 'block-689b54e13a05f'
                ],
                [
                    'type' => 'books_grid',
                    'title' => 'Latest books',
                    'show_title' => true,
                    'categories' => [],
                    'limit' => '5',
                    'sort' => 'newest',
                    'className' => 'mt-6',
                    'id' => 'block-689b54e13a060'
                ],
                [
                    'type' => 'posts_grid',
                    'title' => 'Latest posts',
                    'show_title' => true,
                    'categories' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => 'mt-6',
                    'id' => 'block-689b54e13a061'
                ],
                [
                    'type' => 'quotes_gallery',
                    'title' => 'Gallery',
                    'show_title' => true,
                    'categories' => [],
                    'tags' => [],
                    'users' => [],
                    'authors' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => 'mt-6',
                    'id' => 'block-689b54e13a062'
                ],
                [
                    'type' => 'categories_grid',
                    'title' => 'Categories',
                    'show_title' => true,
                    'users' => [],
                    'limit' => 5,
                    'sort' => 'newest',
                    'className' => 'mt-6',
                    'id' => 'block-689b54e13a063'
                ]
            ]*/
        ];
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homeAll = $this->homePage();
        $homeData = Arr::except($homeAll, ['meta', 'blocks']);
        $home = Post::create($homeData);
        $meta = data_get($homeAll, 'meta');
        $blocks = data_get($homeAll, 'blocks');
        if ($home) {
            if ($meta) {
                $home->saveMetas($meta);
            }
            if ($blocks) {
                $home->saveBlocks($blocks);
            }
            $this->command->info('Homepage created successfully');
        }
        /* Post::create([
            'user_id' => 1,
            'type' => 'page',
            'name' => 'Home',
            'content' => "<p>Welcome to our Homepage</p>",
            'status' => 'publish',
        ])->saveMetas([
            'template' => 'default',
            'blocks' => [
                [
                    'type' => 'quotes_grid',
                    'title' => __('Latest quotes'),
                    'show_title' => true,
                    'limit' => 5,
                    'sort' => 'newest',
                ],
                [
                    'type' => 'books_grid',
                    'title' => __('Latest books'),
                    'show_title' => true,
                    'limit' => 5,
                    'sort' => 'newest',
                ],
                [
                    'type' => 'posts_grid',
                    'title' => __('Latest posts'),
                    'show_title' => true,
                    'limit' => 5,
                    'sort' => 'newest',
                ],
                [
                    'type' => 'text',
                    'content' => fake()->paragraph(),
                ],
            ]
        ]); */
        Post::create([
            'user_id' => 1,
            'type' => 'page',
            'name' => 'Blog',
            'content' => "",
            'status' => 'publish',
        ])->saveMetas([
            'template' => 'default',
        ]);
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
