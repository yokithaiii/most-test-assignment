## Appmost.ru test assignment

### Assignment description:

Необходимо разработать простой REST API для библиотеки. Система
имеет два модели пользователей: пользователи и библиотекари.
Библиотекарь может создавать, просматривать, редактировать и удалять
книги.

Пользователь может просматривать, брать, сдавать книги из библиотеки.

**Все поставленные задачи, в том числе некоторые из дополнительных, выполнены.**

<hr>

### Commands:

Install project

    composer install

Create .env file

Generate key

    php artisan key:generate

Run migrations

    php artisan migrate

Run migrations with seeder

    php artisan migrate --seed

Create librarian with console command

    php artisan librarian:create

Run check borrowed books command

    php artisan borrowed-books:check

<hr>

### Routes

#### Common routes

- `POST /api/user/register` - Регистрация пользователя
- `POST /api/user/login` - Авторизация пользователя
- `GET /api/books` - Получение всех книг

#### User routes

- `GET /api/user/logout` - Выход пользователя
- `POST /api/take-books` - Взять книги из библиотеки
- `POST /api/return-books` - Сдать назад книги

#### Librarian routes

- `GET /api/librarian/logout` - Выход библиотекаря
- `POST /api/books` - Создание книги
- `GET /api/books/{id}` - Просмотр книги
- `PUT /api/books/{id}` - Обновление книги
- `DELETE /api/books/{id}` - Удаление книги
