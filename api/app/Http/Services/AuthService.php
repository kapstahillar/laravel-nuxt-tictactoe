<?php

namespace App\Http\Services;

use App\Exceptions\InvalidLoginCredentials;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function registerUser(RegisterRequest $registerRequest)
    {
        $data = $registerRequest->validated();
        $user = User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        event(new Registered($user));
        Auth::login($user);
    }

    public function login(LoginRequest $loginRequest): bool
    {
        if ($loginRequest->authenticate()) {
            return true;
        } else {
            throw new InvalidLoginCredentials;
        }
    }

    public function logout(Request $request): bool
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return true;
    }
}
