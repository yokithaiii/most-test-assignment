<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'book_url' => $this->book_url,
            'status' => $this->status == 'borrowed' ? 'Не в наличии' : 'В наличии',
            'library' => $this->library ? [
                'id' => $this->library->id,
                'name' => $this->library->name,
                'address' => $this->library->address,
            ] : [],
        ];
    }
}
