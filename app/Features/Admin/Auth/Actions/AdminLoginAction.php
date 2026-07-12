<?php


namespace App\Features\Admin\Auth\Actions;

use App\Features\Admin\Auth\DTOs\LoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginAction
{
    public function execute(LoginDTO $dto)
    {

        if (!Auth::attempt(['email' => $dto->email, 'password' => $dto->password])) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            throw ValidationException::withMessages([
                'email' => ['شما دسترسی ورود به پنل مدیریت را ندارید.'],
            ]);
        }
    }
}
