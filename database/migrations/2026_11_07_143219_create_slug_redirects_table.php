<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slug_redirects', function (Blueprint $table) {
            $table->id();

            $table->string('route_name', 150);

            $table->string('redirectable_type');

            $table->unsignedBigInteger(
                'redirectable_id'
            );

            $table->string('old_slug');

            $table->timestamps();

            $table->unique([
                'route_name',
                'old_slug',
            ]);

            $table->index([
                'redirectable_type',
                'redirectable_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'slug_redirects'
        );
    }
};
