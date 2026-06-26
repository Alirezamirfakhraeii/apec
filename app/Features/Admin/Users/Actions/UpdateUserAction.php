<?php

namespace App\Features\Admin\Users\Actions;

use App\Features\Admin\Users\DTOs\UpdateUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdateUserAction
{
    public function execute(User $user, UpdateUserDTO $dto): User
    {
        if (
            $user->id === Auth::id()
            && $user->hasRole('Super Auth')
            && $dto->role !== 'Super Auth'
        ) {
            throw ValidationException::withMessages([
                'role' => 'شما نمی‌توانید نقش خودتان را از Super Auth تغییر دهید!',
            ]);
        }

        $data = [
            'name' => $dto->name,
            'email' => $dto->email,
        ];

        if ($dto->password) {
            $data['password'] = Hash::make($dto->password);
        }

        $user->update($data);

        if ($dto->role) {
            $user->syncRoles([$dto->role]);
        } else {
            $user->syncRoles([]);
        }

        return $user->fresh('roles');
    }
}
