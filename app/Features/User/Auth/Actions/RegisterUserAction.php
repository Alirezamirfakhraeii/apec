<?php

namespace App\Features\User\Auth\Actions;

use App\Features\User\Auth\DTOs\RegisterData;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction {
    public function execute(RegisterData $data): User {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'mobile' => $data->mobile,
                'name' => $data->name,
            ]);
            $user->assignRole('user');
            return $user;
        });
    }
}
