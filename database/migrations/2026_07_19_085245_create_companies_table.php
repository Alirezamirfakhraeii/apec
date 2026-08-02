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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // اطلاعات پایه شرکت
            $table->string('company_short_name')->nullable();
            $table->string('registered_name')->nullable();
            $table->string('membership_card')->nullable();
            $table->string('company_name_en')->nullable();
            $table->string('nationality')->nullable();

            // اطلاعات ثبتی
            $table->string('registration_date', 20)->nullable();
            $table->string('registration_number')->nullable();
            $table->string('registration_place')->nullable();
            $table->string('national_id')->nullable()->index();
            $table->decimal('registered_capital_irr', 20, 0)->nullable();

            $table->string('parent_company_name')->nullable();
            $table->string('company_type')->nullable();

            // اطلاعات تماس شرکت
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();

            // مدیرعامل
            $table->string('ceo_name')->nullable();
            $table->string('ceo_mobile')->nullable();
            $table->string('ceo_email')->nullable();

            // رئیس هیئت‌مدیره
            $table->string('chairman_name')->nullable();
            $table->string('chairman_mobile')->nullable();
            $table->string('chairman_email')->nullable();

            // اطلاعات روزنامه رسمی
            $table->string('reference_gazette_date', 20)->nullable();

            // رابط انجمن
            $table->string('association_contact_name')->nullable();
            $table->string('association_contact_position')->nullable();
            $table->string('association_contact_mobile')->nullable();
            $table->string('association_contact_email')->nullable();

            // اطلاعات عضویت
            $table->string('association_join_date', 20)->nullable();
            $table->string('membership_number')->nullable()->index();
            $table->string('membership_type')->nullable();
            $table->string('membership_status')->nullable();
            $table->text('membership_status_notes_1403')->nullable();
            $table->text('association_committees')->nullable();

            // کارت بازرگانی
            $table->boolean('has_valid_commercial_card')->nullable();
            $table->string('commercial_card_valid_until', 20)->nullable();

            // کارت عضویت اتاق
            $table->boolean('has_valid_chamber_membership_card')->nullable();
            $table->string('chamber_membership_valid_until', 20)->nullable();
            $table->string('chamber_province')->nullable();

            // حوزه‌های فعالیت
            $table->boolean('activity_design_consulting')->nullable();
            $table->boolean('activity_construction_installation')->nullable();
            $table->boolean('activity_epc')->nullable();
            $table->boolean('activity_mc')->nullable();
            $table->boolean('activity_manufacturing')->nullable();

            // نوع فعالیت
            $table->string('activity_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }


};
