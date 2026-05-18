<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    public function execute(LoginDTO $dto): User
    {
        $isAuthenticated = Auth::attempt([
            'email'    => $dto->email,
            'password' => $dto->password,
        ], $dto->remember);

        if (!$isAuthenticated) {
            throw ValidationException::withMessages([
                'email' => [__('The provided credentials do not match our records.')],
            ]);
        }
        request()->session()->regenerate();
        return Auth::user();
    }
}
