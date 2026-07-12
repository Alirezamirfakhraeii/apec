<?php

namespace App\Http\Controllers\Auth;

use App\Features\User\Auth\Actions\RegisterUserAction;
use App\Features\User\Auth\DTOs\RegisterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.user.register');
    }

    public function register(RegisterRequest $request, RegisterUserAction $action)
    {
        $data = RegisterData::fromRequest($request);
        $user = $action->execute($data);
        auth()->login($user);
        return redirect()->route('dashboard');
    }



}
