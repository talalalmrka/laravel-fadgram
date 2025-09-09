<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public static function createAdmin(): User
    {
        $admin = \App\Models\User::role('admin')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'admin',
                'email' => 'talalminfo@gmail.com',
                'password' => bcrypt('raysh77@@'),
            ]);
            if ($admin) {
                $admin->assignRole('admin');
                $admin->saveMetas([
                    'first_name' => 'Talal',
                    'last_name' => 'Almrka',
                    'display_name' => 'Talal Almrka',
                    'phone' => '+967772800166',
                ]);
            }
        }
        return $admin;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::createAdmin();
        /*User::factory()->create([
            'name' => 'editor',
            'email' => 'editor@gmail.com',
            'password' => bcrypt(1234),
        ])->each(function (User $user) {
            $user->assignRole('editor');
        });
        User::factory()->create([
            'name' => 'member',
            'email' => 'member@gmail.com',
            'password' => bcrypt(1234),
        ])->each(function (User $user) {
            $user->assignRole('member');
        });
        User::factory(27)->create()->each(function (User $user) {
            $user->assignRole('member');
        });*/
    }
}
