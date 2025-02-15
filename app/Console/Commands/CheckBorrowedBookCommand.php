<?php

namespace App\Console\Commands;

use App\Models\Book\BorrowedBook;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckBorrowedBookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'borrowed-books:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $borrowedBooks = BorrowedBook::query()
            ->where('is_returned', false)
            ->where('expires_at', '<=', Carbon::now()->format('Y-m-d'))
            ->get();

        foreach ($borrowedBooks as $borrowedBook) {
            $borrowedBook->is_expired = true;
        }

        $this->info('Ежедневная проверка прошла успешно');
    }
}
