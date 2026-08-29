<?php

namespace App\Features\Admin\Users\Actions;

use App\Features\Admin\Users\DTOs\CreateUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{

    public function execute(CreateUserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {

            $user = User::create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
                'avatar' => null,
            ]);

            if ($dto->avatar) {
                $avatarPath = $dto->avatar->store(
                    'user/' . $user->id . '/avatar',
                    'public'
                );

                $user->update([
                    'avatar' => $avatarPath,
                ]);
            }

            if ($dto->role) {
                $user->assignRole($dto->role);
            }

            return $user;
        });
    }

}
