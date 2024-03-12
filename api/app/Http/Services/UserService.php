<?php
use App\Http\Requests\RegisterUserRequest;

class UserService
{

    public function register(RegisterUserRequest $request): User
    {
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        return $user;
    }
}