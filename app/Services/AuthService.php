<?php

namespace App\Services;

use App\Models\Library\Librarian;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $input): JsonResponse
    {
        $user = User::query()->create([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'] ?? null,
            'email' => $input['email'],
            'password' =>  Hash::make($input['password']),
        ]);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Cant create user!'
            ], 400);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $token
            ]
        ]);
    }

    public function login(array $input, string $type = 'user'): JsonResponse
    {
        $model = $type === 'librarian' ? Librarian::class : User::class;
        $user = $model::where('email', $input['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => ucfirst($type) . ' not found!'
            ], 404);
        }

        if (!Hash::check($input['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'error' => 'Введенные данные неверные!'
            ], 400);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $token
            ]
        ]);
    }

    public function logout($request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout success!'], 200);
    }
}
