<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidLoginCredentials;
use App\Exceptions\UsernameAlreadyInUse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $data = $request->validated();
        $user = User::create([
            'username' => $data["username"],
            'password' => Hash::make($data["password"]),
        ]);
        event(new Registered($user));
        Auth::login($user);
        return response()->noContent();
    }

    public function login(LoginRequest $request)
    {
        if ($request->authenticate()) {
            return response()->noContent();
        } else {
            throw new InvalidLoginCredentials;
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->noContent();
    }
}