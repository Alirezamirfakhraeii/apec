<?php

namespace App\Http\Controllers\Auth;

use App\Features\Auth\Actions\LoginUserAction;
use App\Features\Auth\DTOs\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.users.login');
    }

    public function login(LoginRequest $request, LoginUserAction $action): RedirectResponse
    {
        $dto = LoginDTO::fromRequest($request);
        $user = $action->execute($dto);
        return redirect()->intended(route($user->dashboardRoute()));
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }


}
