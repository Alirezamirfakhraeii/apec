<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ادمین/نویسنده مقاله
            $table->foreignId('blog_category_id')->nullable()->constrained()->onDelete('set null'); // دسته‌بندی
            $table->string('title'); // عنوان مقاله
            $table->string('slug')->unique(); // اسلاگ سئو شده
            $table->string('image')->nullable(); // آدرس تصویر شاخص اصلی
            $table->longText('body'); // متن اصلی مقاله که از CKEditor میاد
            $table->string('summary', 500)->nullable(); // خلاصه‌ای کوتاه برای بخش کارت‌های بلاگ

            // بخش سئو (SEO Meta)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // وضعیت‌ها
            $table->enum('status', ['draft', 'published'])->default('draft'); // پیش‌نویس یا منتشر شده
            $table->unsignedInteger('view_count')->default(0); // تعداد بازدیدها

            $table->timestamp('published_at')->nullable(); // زمان انتشار (برای زمان‌بندی پست‌ها)
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
