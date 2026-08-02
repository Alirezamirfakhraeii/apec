<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_activity_field', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('activity_field_id')
                ->constrained('activity_fields')
                ->cascadeOnDelete();

            $table->primary([
                'company_id',
                'activity_field_id',
            ]);

            $table->index([
                'activity_field_id',
                'company_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_activity_field');
    }
};
