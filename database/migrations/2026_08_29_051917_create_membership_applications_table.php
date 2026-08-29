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

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('state')
                ->default('draft');

            $table->foreignId('current_stage_id')
                ->nullable()
                ->constrained('workflow_stages')
                ->nullOnDelete();

            $table->foreignId('return_stage_id')
                ->nullable()
                ->constrained('workflow_stages')
                ->nullOnDelete();

            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamp('approved_at')
                ->nullable();

            $table->timestamp('rejected_at')
                ->nullable();

            $table->timestamps();

            $table->index('state');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
