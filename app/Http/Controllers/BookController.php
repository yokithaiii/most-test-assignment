<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\ReturnBookRequest;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\TakeBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookResource;
use App\Models\Book\Book;
use App\Models\Book\BorrowedBook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = $request->input('q', null);
        $page = (int)$request->input('page', 1);
        $perPage = (int)$request->input('per_page', 10);

        $query = Book::query();

        if ($q) {
            $query->where('name', 'LIKE', '%' . $q . '%');
        }

        $books = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => BookResource::collection($books),
            'pagination' => [
                'current_page' => $books->currentPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
                'last_page' => $books->lastPage(),
                'from' => $books->firstItem(),
                'to' => $books->lastItem(),
            ]
        ]);
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        $input = $request->validated();

        $book = Book::query()->create([
            'library_id' => $input['library_id'],
            'name' => $input['name'],
            'price' => $input['price'],
            'book_url' => $input['book_url']
        ]);

        if (!$book) {
            return response()->json(['error' => 'Cant create book!'], 400);
        }

        return response()->json([
            'message' => 'Book created success!',
            'data' => BookResource::make($book)
        ], 201);
    }

    public function update(String $id, UpdateBookRequest $request): JsonResponse
    {
        $book = Book::query()->find($id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $input = $request->validated();

        if (!$book->update($input)) {
            return response()->json(['error' => 'Cant update book!'], 400);
        }

        return response()->json([
            'message' => 'Book updated success!',
            'data' => BookResource::make($book)
        ], 200);
    }

    public function show(String $id): JsonResponse
    {
        $book = Book::query()->find($id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json([
            'data' => BookResource::make($book)
        ], 200);
    }

    public function destroy(String $id): JsonResponse
    {
        $book = Book::query()->find($id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted success!'], 200);
    }

    public function takeBooks(TakeBookRequest $request): JsonResponse
    {
        $input = $request->validated();
        $userId = Auth::id();

        return DB::transaction(function () use ($input, $userId) {
            foreach ($input['book_ids'] as $bookId) {
                $book = Book::query()->find($bookId);

                if ($book->status !== 'free') {
                    return response()->json(['error' => 'Книга ' . $book->name . 'уже на прокате'], 400);
                }

                BorrowedBook::query()->create([
                    'book_id' => $bookId,
                    'user_id' => $userId,
                    'expires_at' => Carbon::now()->addDays($input['days'])->format('Y-m-d'),
                    'checkout_date' => Carbon::now()->format('Y-m-d'),
                ]);

                $book->update(['status' => 'borrowed']);
            }

            return response()->json(['message' => 'Take books success!'], 200);
        });
    }

    public function returnBooks(ReturnBookRequest $request): JsonResponse
    {
        $input = $request->validated();
        $userId = Auth::id();

        return DB::transaction(function () use ($input, $userId) {
            $borrowedBooks = BorrowedBook::query()
                ->where('user_id', $userId)
                ->whereIn('book_id', $input['book_ids'])
                ->where('is_returned', false)
                ->get();

            if ($borrowedBooks->isEmpty()) {
                return response()->json(['error' => 'Borrowed books not found'], 404);
            }

            foreach ($borrowedBooks as $borrowedBook) {
                $borrowedBooks->is_returned = true;
                $borrowedBook->save();

                $book = Book::query()->find($borrowedBook->book_id);
                if ($book) {
                    $book->status = 'free';
                    $book->save();
                }
            }

            return response()->json(['message' => 'Return books success!'], 200);
        });
    }
}
