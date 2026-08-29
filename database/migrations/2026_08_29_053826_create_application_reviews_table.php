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

            $table->foreignId('membership_application_id')
                ->constrained('membership_applications')
                ->cascadeOnDelete();

            $table->foreignId('reviewer_id')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete();

            $table->foreignId('stage_id')
                ->constrained('workflow_stages')
                ->restrictOnDelete();

            $table->string('decision');
            $table->text('comment')->nullable();

            $table->timestamps();

            $table->index(
                ['membership_application_id', 'stage_id'],
                'application_reviews_application_stage_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_reviews');
    }
};
