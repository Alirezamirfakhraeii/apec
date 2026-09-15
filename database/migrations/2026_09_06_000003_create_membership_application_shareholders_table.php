<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'membership_application_shareholders',
            function (Blueprint $table) {

                $table->id();

                $table->unsignedBigInteger(
                    'membership_application_id'
                );

                $table->string('full_name');

                $table->decimal(
                    'ownership_percentage',
                    5,
                    2
                );

                $table->unsignedSmallInteger(
                    'sort_order'
                )->default(0);

                $table->timestamps();


                $table->foreign(
                    'membership_application_id',
                    'membership_shareholder_application_fk'
                )
                    ->references('id')
                    ->on('membership_applications')
                    ->cascadeOnDelete();


                $table->index(
                    [
                        'membership_application_id',
                        'sort_order',
                    ],
                    'membership_shareholder_order_idx'
                );
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'membership_application_shareholders'
        );
    }
};
