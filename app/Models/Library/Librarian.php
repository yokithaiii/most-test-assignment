<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Librarian extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'librarians';

    protected $fillable = [
        'firstname',
        'lastname',
        'library_id',
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class, 'library_id', 'id');
    }
}
