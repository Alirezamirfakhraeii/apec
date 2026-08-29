<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('user')
                ->cascadeOnDelete();

            $table->foreignId('blog_category_id')
                ->nullable()
                ->constrained('blog_categories')
                ->nullOnDelete();

            $table->string('type');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->longText('body');
            $table->string('summary', 500)->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
