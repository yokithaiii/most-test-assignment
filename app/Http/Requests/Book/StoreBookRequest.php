<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\Api\ApiRequest;

class StoreBookRequest extends ApiRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:100',
            'book_url' => 'nullable',
            'library_id' => 'required|string|exists:libraries,id'
        ];
    }
}
