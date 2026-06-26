<?php

namespace App\Features\Auth\Actions;

use App\Features\Auth\DTOs\RegisterData;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
