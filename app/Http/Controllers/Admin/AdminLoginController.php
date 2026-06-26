<?php

namespace App\Http\Controllers\Admin;

use App\Features\Auth\Actions\AdminLoginAction;
use App\Features\Auth\DTOs\AdminLoginDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function login(Request $request, AdminLoginAction $action)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $dto = AdminLoginDTO::fromRequest($request);

        $action->execute($dto);

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
