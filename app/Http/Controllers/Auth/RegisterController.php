<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\DTOs\Auth\RegisterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request, RegisterUserAction $action)
    {
        $data = RegisterData::fromRequest($request);
        $user = $action->execute($data);
        auth()->login($user);
        return redirect()->route('dashboard');
    }



}
