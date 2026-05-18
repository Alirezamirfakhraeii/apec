<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'), // حتما بعدا عوضش کن!
            'is_active' => true,
        ]);

        // اختصاص نقش ادمین که در سیدر قبلی ساختیم
        $admin->assignRole('admin');
    }
}
