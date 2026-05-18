<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\DTOs\Auth\RegisterData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterUserAction {
    public function execute(RegisterData $data): User {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'mobile' => $data->mobile,
            ]);
            $user->assignRole('user');
            return $user;
        });
    }
}
