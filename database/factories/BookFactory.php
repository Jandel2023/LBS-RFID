<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $author = Author::count();
        $category = Category::count();

        return [
            //
            'isbn' => fake()->unique()->numberBetween(00000, 99999),
            'title' => fake()->unique()->sentence(3),
            'author_id' => fake()->numberBetween(1, $author),
            'category_id' => fake()->numberBetween(1, $category),
            'published_date' => fake()->date(max: 'now'),
        ];
    }
}
