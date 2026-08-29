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

            /*
            |--------------------------------------------------------------------------
            | Membership Application
            |--------------------------------------------------------------------------
            */

            $table->foreignId('membership_application_id');

            $table->unique(
                'membership_application_id',
                'membership_company_application_unique'
            );

            $table->foreign(
                'membership_application_id',
                'membership_company_application_fk'
            )
                ->references('id')
                ->on('membership_applications')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Basic Company Information
            |--------------------------------------------------------------------------
            */

            $table->string('logo_path')->nullable();

            $table->string('company_short_name')->nullable();

            $table->string('registered_name')->nullable();

            $table->string('company_name_en')->nullable();

            $table->string('nationality')->nullable();

            $table->string('parent_company_name')->nullable();

            $table->string('company_type')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Registration Information
            |--------------------------------------------------------------------------
            */

            $table->date('registration_date')->nullable();

            $table->string('registration_number')->nullable();

            $table->string('registration_place')->nullable();

            $table->string('national_id')->nullable();

            $table->decimal(
                'registered_capital_irr',
                20,
                0
            )->nullable();

            $table->date('reference_gazette_date')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */

            $table->string('phone')->nullable();

            $table->string('fax')->nullable();

            $table->string('email')->nullable();

            $table->string('website')->nullable();

            $table->text('address')->nullable();


            /*
            |--------------------------------------------------------------------------
            | CEO
            |--------------------------------------------------------------------------
            */

            $table->string('ceo_name')->nullable();

            $table->string('ceo_mobile')->nullable();

            $table->string('ceo_email')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Chairman
            |--------------------------------------------------------------------------
            */

            $table->string('chairman_name')->nullable();

            $table->string('chairman_mobile')->nullable();

            $table->string('chairman_email')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Association Contact
            |--------------------------------------------------------------------------
            */

            $table->string('association_contact_name')->nullable();

            $table->string('association_contact_position')->nullable();

            $table->string('association_contact_mobile')->nullable();

            $table->string('association_contact_email')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Commercial Card
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_valid_commercial_card')->nullable();

            $table->date('commercial_card_valid_until')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Chamber Membership
            |--------------------------------------------------------------------------
            */

            $table->boolean(
                'has_valid_chamber_membership_card'
            )->nullable();

            $table->date(
                'chamber_membership_valid_until'
            )->nullable();

            $table->string('chamber_province')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Activities
            |--------------------------------------------------------------------------
            */

            $table->boolean('activity_design_consulting')
                ->default(false);

            $table->boolean('activity_construction_installation')
                ->default(false);

            $table->boolean('activity_epc')
                ->default(false);

            $table->boolean('activity_mc')
                ->default(false);

            $table->boolean('activity_manufacturing')
                ->default(false);

            $table->longText('activity_type')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Membership Request
            |--------------------------------------------------------------------------
            */

            $table->string('membership_type')->nullable();

            $table->text('association_committees')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index(
                'national_id',
                'membership_company_national_id_idx'
            );

            $table->index(
                'registration_number',
                'membership_company_registration_idx'
            );

            $table->index(
                'email',
                'membership_company_email_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_company_profiles');
    }
};
