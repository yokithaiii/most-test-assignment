<?php

namespace Database\Factories\Book;

use App\Models\Library\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book\Book>
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
        return [
            'name' => fake()->sentence(rand(1, 4)),
            'price' => round(rand(300, 990), -2),
            'book_url' => fake()->imageUrl(),
            'library_id' => Library::query()->inRandomOrder()->value('id') ?? Library::factory()->create()->id,
        ];
    }
}
