<?php

namespace App\Actions\Auth\Admin;

use App\DTOs\Auth\Admin\AdminLoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginAction
{
    public function execute(AdminLoginDTO $dto): bool
    {
        // ۱. تلاش برای احراز هویت اولیه با سشن‌های پیش‌فرض لاراول
        if (!Auth::attempt(['email' => $dto->email, 'password' => $dto->password], $dto->remember)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        // ۲. گارد امنیتی: اگر کاربر لاگین شد ولی رول ادمین نداشت، بلافاصله سشن را بسوزان!
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => ['شما دسترسی ورود به پنل مدیریت را ندارید.'],
            ]);
        }

        // ۳. تجدید توکن سشن برای جلوگیری از حملات Session Fixation
        request()->session()->regenerate();

        return true;
    }
}
