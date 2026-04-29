<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $templates = [
            'How to master '.$this->faker->word().' in 2024',
            'Top 10 tips for '.$this->faker->word().' developers',
            'Why '.$this->faker->word().' is essential for your project',
            'Getting started with '.$this->faker->word().' and Laravel',
            'Advanced '.$this->faker->word().' techniques',
            'Building a scalable system with '.$this->faker->word(),
        ];

        $title = $this->faker->randomElement($templates);

        return [
            'user_id' => User::query()->inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::query()->inRandomOrder()->first()?->id ?? Category::factory(),
            'title' => ucfirst($title),
            'slug' => Str::slug($title).'-'.Str::random(8),
            'excerpt' => $this->faker->sentence(12),
            'content' => $this->faker->paragraphs(5, true),
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
