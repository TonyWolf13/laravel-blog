<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'content' => fake()->randomHtml(),
            'thumbnail' => fake()->imageUrl(640, 480, 'animals', true),
            'banner' => fake()->imageUrl(1080, 480, 'animals', true),
            'publish_at' => null
        ];
    }
}
