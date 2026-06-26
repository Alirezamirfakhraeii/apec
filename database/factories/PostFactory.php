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
        $title = $this->faker->realText(60);

        return [
            'title'        => $title,
            'slug'         => Str::slug($title) ?: Str::random(8),
            'summary'      => $this->faker->realText(150),
            'body'         => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            'image'        => null,
            'views'        => $this->faker->numberBetween(10, 2500),
            'status'       => 'published',
            'published_at' => now()->subMinutes($this->faker->numberBetween(1, 50000)),
            'user_id'      => User::first()?->id ?? User::factory(),
            'category_id'  => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }
}
