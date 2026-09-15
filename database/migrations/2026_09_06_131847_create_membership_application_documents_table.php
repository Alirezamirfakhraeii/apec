<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'membership_application_documents',
            function (Blueprint $table) {

                $table->id();

                $table->unsignedBigInteger(
                    'membership_application_id'
                );

                /*
                |--------------------------------------------------------------------------
                | Document Type
                |--------------------------------------------------------------------------
                |
                | official_gazette
                | latest_general_assembly_minutes
                | latest_capital_gazette
                | original_certificate
                | company_resume
                | chamber_membership_card
                |
                */

                $table->string('type');

                $table->string('path');

                $table->string('original_name');

                $table->string(
                    'mime_type',
                    100
                )->nullable();

                $table->unsignedBigInteger('size')
                    ->nullable();

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | Foreign Key
                |--------------------------------------------------------------------------
                */

                $table->foreign(
                    'membership_application_id',
                    'membership_document_application_fk'
                )
                    ->references('id')
                    ->on('membership_applications')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | One active document per type
                |--------------------------------------------------------------------------
                */

                $table->unique(
                    [
                        'membership_application_id',
                        'type',
                    ],
                    'membership_document_type_unique'
                );
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'membership_application_documents'
        );
    }
};
