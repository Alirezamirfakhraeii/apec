<?php

namespace Database\Seeders;

use App\Models\WorkflowStage;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class MembershipWorkflowSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = [
            'user',
            'it_specialist',
            'association_secretary',
            'membership_chair',
            'board_chairman',
            'admin',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [
            'membership.application.review.it',
            'membership.application.review.secretary',
            'membership.application.review.chair',
            'membership.application.review.board',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Workflow Stages
        |--------------------------------------------------------------------------
        */

        WorkflowStage::updateOrCreate(
            [
                'code' => 'it_specialist',
            ],
            [
                'name' => 'کارشناس فناوری اطلاعات',
                'position' => 1,

                'required_permission' =>
                    'membership.application.review.it',

                'is_final' => false,
                'is_active' => true,
            ]
        );


        WorkflowStage::updateOrCreate(
            [
                'code' => 'association_secretary',
            ],
            [
                'name' => 'دبیر انجمن',
                'position' => 2,

                'required_permission' =>
                    'membership.application.review.secretary',

                'is_final' => false,
                'is_active' => true,
            ]
        );


        WorkflowStage::updateOrCreate(
            [
                'code' => 'membership_chair',
            ],
            [
                'name' => 'رئیس کمیته عضویت',
                'position' => 3,

                'required_permission' =>
                    'membership.application.review.chair',

                'is_final' => false,
                'is_active' => true,
            ]
        );


        WorkflowStage::updateOrCreate(
            [
                'code' => 'board_chairman',
            ],
            [
                'name' => 'رئیس هیئت مدیره',
                'position' => 4,

                'required_permission' =>
                    'membership.application.review.board',

                'is_final' => true,
                'is_active' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Assign Permissions To Existing Roles
        |--------------------------------------------------------------------------
        */

        Role::findByName('it_specialist', 'web')
            ->givePermissionTo(
                'membership.application.review.it'
            );


        Role::findByName('association_secretary', 'web')
            ->givePermissionTo(
                'membership.application.review.secretary'
            );


        Role::findByName('membership_chair', 'web')
            ->givePermissionTo(
                'membership.application.review.chair'
            );


        Role::findByName('board_chairman', 'web')
            ->givePermissionTo(
                'membership.application.review.board'
            );


        /*
        |--------------------------------------------------------------------------
        | Clear Cache Again
        |--------------------------------------------------------------------------
        */

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();
    }
}
