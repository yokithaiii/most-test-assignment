<?php

namespace App\Console\Commands;

use App\Models\Library\Librarian;
use App\Models\Library\Library;
use Illuminate\Console\Command;

class CreateLibrarianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librarian:create';

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
        $firstname = $this->ask('Введите Имя библиотекаря:');
        $lastname = $this->ask('Введите Фамилию библиотекаря:');

        $libraries = Library::query()->get();
        if ($libraries->isEmpty()) {
            $this->error('Библиотеки не найдены!');
            return;
        }

        $libraryChoices = $libraries->pluck('name')->toArray();
        $selectedLibrary = $this->choice('Выберите библиотеку на которого хотите прикрепить:', $libraryChoices);

        $library = $libraries->where('name', $selectedLibrary)->first();

        Librarian::query()->updateOrCreate([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'library_id' => $library->id
        ]);

        $this->info('Библиотекарь успешно создан и прикреплен к библиотеке ' . '"'. $library->name . '"');
    }
}
