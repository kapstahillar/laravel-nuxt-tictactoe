<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->registerUser($request);
        return response()->noContent();
    }

    public function login(LoginRequest $request)
    {
        $this->authService->login($request);
        return response()->noContent();
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return response()->noContent();
    }
}