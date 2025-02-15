<?php

namespace App\Models\Book;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowedBook extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'borrowed_books';

    protected $fillable = [
        'book_id',
        'user_id',
        'checkout_date',
        'expires_at',
        'is_returned'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
