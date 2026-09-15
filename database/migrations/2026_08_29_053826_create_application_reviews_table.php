<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger(
                'membership_application_id'
            );

            $table->unsignedBigInteger(
                'reviewer_id'
            )->nullable();

            $table->unsignedBigInteger(
                'stage_id'
            );

            $table->string('decision');

            $table->text('comment')
                ->nullable();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Foreign Keys
            |--------------------------------------------------------------------------
            */

            $table->foreign(
                'membership_application_id',
                'application_review_application_fk'
            )
                ->references('id')
                ->on('membership_applications')
                ->cascadeOnDelete();


            $table->foreign(
                'reviewer_id',
                'application_review_reviewer_fk'
            )
                ->references('id')
                ->on('users')
                ->nullOnDelete();


            $table->foreign(
                'stage_id',
                'application_review_stage_fk'
            )
                ->references('id')
                ->on('workflow_stages')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index(
                [
                    'membership_application_id',
                    'stage_id',
                ],
                'application_review_app_stage_idx'
            );

            $table->index(
                'reviewer_id',
                'application_review_reviewer_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_reviews');
    }
};
