<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('url')->nullable();

            $table->string('type')->default('image'); // image, video, file
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();

            $table->integer('width')->nullable();
            $table->integer('height')->nullable();

            $table->string('alt')->nullable();
            $table->string('caption')->nullable();

            $table->boolean('is_main')->default(false);

            $table->morphs('mediable');

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
