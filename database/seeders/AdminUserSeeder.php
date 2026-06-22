<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Auth',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);

        // اختصاص نقش ادمین که در سیدر قبلی ساختیم
        $admin->assignRole('admin');
    }
}
