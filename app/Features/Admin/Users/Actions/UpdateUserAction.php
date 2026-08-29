<?php

namespace App\Features\Admin\Users\Actions;

use App\Features\Admin\Users\DTOs\UpdateUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UpdateUserAction
{
    public function execute(User $user, UpdateUserDTO $dto): User
    {
        $data = [
            'name' => $dto->name,
            'email' => $dto->email,
        ];

        if (!empty($dto->password)) {
            $data['password'] = Hash::make($dto->password);
        }

        if ($dto->avatar) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $dto->avatar->store(
                'user/' . $user->id . '/avatar',
                'public'
            );
        }

        $user->update($data);

        $user->syncRoles($dto->role ? [$dto->role] : []);

        return $user;
    }
}
