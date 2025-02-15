<?php

namespace Database\Seeders;

use App\Models\Library\Librarian;
use App\Models\Library\Library;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();
         Library::factory(2)->create();
         Librarian::factory(3)->create();
    }
}
