<?php

namespace App\Models\Book;

use App\Models\Library\Library;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'library_id',
        'name',
        'price',
        'book_url',
        'status'
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class, 'library_id', 'id');
    }
}
