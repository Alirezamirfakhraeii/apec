<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Owner
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('user_id');


            /*
            |--------------------------------------------------------------------------
            | Official Company
            |--------------------------------------------------------------------------
            |
            | تا قبل از تایید نهایی null می‌ماند.
            |
            */

            $table->unsignedBigInteger('company_id')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Intake
            |--------------------------------------------------------------------------
            */

            $table->string('intake_company_name')
                ->nullable();

            $table->string('representative_name')
                ->nullable();

            $table->string('representative_mobile', 20)
                ->nullable();

            $table->timestamp('intake_confirmed_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Workflow
            |--------------------------------------------------------------------------
            */

            $table->string('state')
                ->default('draft');

            $table->unsignedBigInteger('current_stage_id')
                ->nullable();

            $table->unsignedBigInteger('return_stage_id')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Workflow Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamp('approved_at')
                ->nullable();

            $table->timestamp('rejected_at')
                ->nullable();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Foreign Keys
            |--------------------------------------------------------------------------
            */

            $table->foreign(
                'user_id',
                'membership_application_user_fk'
            )
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();


            $table->foreign(
                'company_id',
                'membership_application_company_fk'
            )
                ->references('id')
                ->on('companies')
                ->nullOnDelete();


            $table->foreign(
                'current_stage_id',
                'membership_application_current_stage_fk'
            )
                ->references('id')
                ->on('workflow_stages')
                ->nullOnDelete();


            $table->foreign(
                'return_stage_id',
                'membership_application_return_stage_fk'
            )
                ->references('id')
                ->on('workflow_stages')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index(
                'user_id',
                'membership_application_user_idx'
            );

            $table->index(
                'state',
                'membership_application_state_idx'
            );

            $table->index(
                'current_stage_id',
                'membership_application_stage_idx'
            );

            $table->index(
                'representative_mobile',
                'membership_application_mobile_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
