<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Library extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'libraries';

    protected $fillable = [
        'name',
        'address'
    ];

    public function librarians(): HasMany
    {
        return $this->hasMany(Librarian::class, 'library_id', 'id');
    }
}
