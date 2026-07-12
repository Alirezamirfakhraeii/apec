<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\Auth\Actions\AdminLoginAction;
use App\Features\Admin\Auth\DTOs\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('back.admin.auth.login');
    }

    public function login(LoginRequest $request, AdminLoginAction $action)
    {
        $dto = LoginDTO::fromRequest($request);

        $loggedIn = $action->execute($dto);

        if (! $loggedIn) {
            throw ValidationException::withMessages([
                'email' => 'ایمیل یا رمز عبور اشتباه است.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
