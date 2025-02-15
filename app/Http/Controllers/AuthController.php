<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;
    public function __construct (AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function registerUser(RegisterRequest $request): JsonResponse
    {
        $input = $request->validated();

        return $this->authService->register($input);
    }

    public function loginUser(LoginRequest $request): JsonResponse
    {
        $input = $request->validated();
        $type = 'user';

        return $this->authService->login($input, $type);
    }

    public function logoutUser(Request $request): JsonResponse
    {
        return $this->authService->logout($request);
    }

    public function loginLibrarian(LoginRequest $request): JsonResponse
    {
        $input = $request->validated();
        $type = 'librarian';

        return $this->authService->login($input, $type);
    }

    public function logoutLibrarian(Request $request): JsonResponse
    {
        return $this->authService->logout($request);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }
}
