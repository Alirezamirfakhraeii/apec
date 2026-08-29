<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The template column already exists in the original pages migration.
     * This migration is intentionally kept as a no-op to preserve migration history.
     */
    public function up(): void
    {
        // No-op.
    }

    public function down(): void
    {
        // No-op. The template column belongs to create_pages_table.
    }
};
