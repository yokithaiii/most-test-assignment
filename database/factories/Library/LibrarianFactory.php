<?php

namespace Database\Factories\Library;

use App\Models\Library\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Library\Librarian>
 */
class LibrarianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $libraryId = Library::query()->inRandomOrder()->value('id') ?? Library::factory()->create()->id;
        return [
            'firstname' => fake()->firstName('female'),
            'lastname' => fake()->lastName('female'),
            'library_id' => $libraryId,
            'email' => fake()->email(),
            'password' => fake()->password()
        ];
    }
}
