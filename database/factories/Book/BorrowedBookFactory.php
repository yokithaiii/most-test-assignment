<?php

namespace Database\Factories\Book;

use App\Models\Book\Book;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BorrowedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $book = Book::query()
            ->inRandomOrder()
            ->where('status', 'free')
            ->first() ?? Book::factory()->create();
        $book->status = 'borrowed';
        $book->save();

        $userId = User::query()->inRandomOrder()->value('id') ?? User::factory()->create()->id;
        return [
            'book_id' => $book->id,
            'user_id' => $userId,
            'checkout_date' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(rand(3, 30)),
        ];
    }
}
