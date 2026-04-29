<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(12)->create();

        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->moderator()->create([
            'name' => 'Moderator User',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->author()->has(Post::factory()->count(3))->create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->user()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        Post::factory(10)->create();
    }
}
