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
        Schema::create('company_projects', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | شرکت
            |--------------------------------------------------------------------------
            */

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | اطلاعات پروژه
            |--------------------------------------------------------------------------
            */

            // نام پروژه
            $table->string('project_name');

            // کارفرما
            $table->string('employer')->nullable();

            // تاریخ شروع پروژه
            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            // شرح خدمات
            $table->longText('service_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_projects');
    }
};
