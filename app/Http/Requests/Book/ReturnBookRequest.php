<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\Api\ApiRequest;

class ReturnBookRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_ids' => 'array|required|min:1',
            'book_ids.*' => 'uuid|exists:books,id',
        ];
    }
}
