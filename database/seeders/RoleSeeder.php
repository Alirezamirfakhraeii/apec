<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ۱. تعریف نقش‌ها
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $userRole = Role::create(['name' => 'user']);

        // ۲. تعریف دسترسی‌های نمونه (برای مثال)
        $permissions = [
            'manage posts',
            'delete posts',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ۳. تخصیص دسترسی به نقش‌ها
        $adminRole->givePermissionTo(Permission::all());
        $editorRole->givePermissionTo(['manage posts']);
    }
}
