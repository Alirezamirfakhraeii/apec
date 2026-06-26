<?php

namespace App\Features\Admin\Users\Actions;

use App\Features\Admin\Users\DTOs\CreateUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{

    public function execute(CreateUserDTO $dto): User
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        if ($dto->role) {
            $user->assignRole($dto->role);
        }

        return $user;
    }
}
