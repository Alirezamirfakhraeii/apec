<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_company_profiles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger(
                'membership_application_id'
            );


            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            $table->string('logo_path')
                ->nullable();

            $table->string('company_short_name')
                ->nullable();

            $table->string('registered_name')
                ->nullable();

            $table->string('company_name_en')
                ->nullable();

            $table->string('nationality')
                ->nullable();

            $table->string('parent_company_name')
                ->nullable();

            $table->string('company_type')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Registration Information
            |--------------------------------------------------------------------------
            */

            $table->date('registration_date')
                ->nullable();

            $table->string('registration_number')
                ->nullable();

            $table->string('registration_place')
                ->nullable();

            $table->string('national_id')
                ->nullable();

            $table->decimal(
                'registered_capital_irr',
                20,
                0
            )->nullable();

            $table->date('reference_gazette_date')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */

            $table->string('phone')
                ->nullable();

            $table->string('fax')
                ->nullable();

            $table->string('email')
                ->nullable();

            $table->string('website')
                ->nullable();

            $table->text('address')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | CEO
            |--------------------------------------------------------------------------
            */

            $table->string('ceo_name')
                ->nullable();

            $table->string('ceo_mobile', 20)
                ->nullable();

            $table->string('ceo_email')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Chairman
            |--------------------------------------------------------------------------
            */

            $table->string('chairman_name')
                ->nullable();

            $table->string('chairman_mobile', 20)
                ->nullable();

            $table->string('chairman_email')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Association Contact
            |--------------------------------------------------------------------------
            */

            $table->string('association_contact_name')
                ->nullable();

            $table->string('association_contact_position')
                ->nullable();

            $table->string('association_contact_mobile', 20)
                ->nullable();

            $table->string('association_contact_email')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Commercial Card
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_valid_commercial_card')
                ->nullable();

            $table->date('commercial_card_valid_until')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Chamber Of Commerce
            |--------------------------------------------------------------------------
            */

            $table->boolean(
                'has_valid_chamber_membership_card'
            )->nullable();

            $table->date(
                'chamber_membership_valid_until'
            )->nullable();

            $table->string('chamber_province')
                ->nullable();

            $table->boolean('is_chamber_member')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Experience & Specialty
            |--------------------------------------------------------------------------
            */

            $table->unsignedSmallInteger(
                'activity_experience_years'
            )->nullable();

            $table->text(
                'oil_gas_petchem_specialty'
            )->nullable();


            /*
            |--------------------------------------------------------------------------
            | Activities
            |--------------------------------------------------------------------------
            */

            $table->boolean(
                'activity_design_consulting'
            )->default(false);

            $table->boolean(
                'activity_construction_installation'
            )->default(false);

            $table->boolean('activity_epc')
                ->default(false);

            $table->boolean('activity_mc')
                ->default(false);

            $table->boolean(
                'activity_manufacturing'
            )->default(false);

            $table->longText('activity_type')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Membership Information
            |--------------------------------------------------------------------------
            */

            $table->string('membership_type')
                ->nullable();

            $table->text('association_committees')
                ->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Foreign Key
            |--------------------------------------------------------------------------
            */

            $table->foreign(
                'membership_application_id',
                'membership_profile_application_fk'
            )
                ->references('id')
                ->on('membership_applications')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | One profile per application
            |--------------------------------------------------------------------------
            */

            $table->unique(
                'membership_application_id',
                'membership_profile_application_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'membership_company_profiles'
        );
    }
};
