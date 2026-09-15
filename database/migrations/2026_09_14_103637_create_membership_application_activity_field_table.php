<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'membership_application_activity_field',
            function (Blueprint $table) {
                $table->unsignedBigInteger(
                    'membership_application_id'
                );

                $table->unsignedBigInteger(
                    'activity_field_id'
                );

                $table->timestamps();

                $table->primary(
                    [
                        'membership_application_id',
                        'activity_field_id',
                    ],
                    'maa_primary'
                );

                $table->foreign(
                    'membership_application_id',
                    'maa_application_fk'
                )
                    ->references('id')
                    ->on('membership_applications')
                    ->cascadeOnDelete();

                $table->foreign(
                    'activity_field_id',
                    'maa_activity_fk'
                )
                    ->references('id')
                    ->on('activity_fields')
                    ->cascadeOnDelete();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'membership_application_activity_field'
        );
    }
};
