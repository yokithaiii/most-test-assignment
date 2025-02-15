<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Librarian extends Authenticatable
{
    use HasApiTokens, HasUuids, HasFactory;

    protected $table = 'librarians';

    protected $fillable = [
        'firstname',
        'lastname',
        'library_id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class, 'library_id', 'id');
    }
}
