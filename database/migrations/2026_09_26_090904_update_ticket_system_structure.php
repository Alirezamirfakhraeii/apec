<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Tickets
        |--------------------------------------------------------------------------
        */

        Schema::table('tickets', function (Blueprint $table) {

            if (!Schema::hasColumn('tickets', 'priority')) {
                $table
                    ->string('priority', 20)
                    ->default('normal')
                    ->after('status');
            }

            if (!Schema::hasColumn('tickets', 'last_message_at')) {
                $table
                    ->timestamp('last_message_at')
                    ->nullable()
                    ->after('priority');
            }

            if (!Schema::hasColumn('tickets', 'closed_at')) {
                $table
                    ->timestamp('closed_at')
                    ->nullable()
                    ->after('last_message_at');
            }
        });


        /*
        |--------------------------------------------------------------------------
        | Ticket Messages
        |--------------------------------------------------------------------------
        */

        Schema::table('ticket_messages', function (Blueprint $table) {

            if (!Schema::hasColumn('ticket_messages', 'sender_type')) {
                $table
                    ->string('sender_type', 20)
                    ->default('user')
                    ->after('user_id');
            }
        });


        /*
        |--------------------------------------------------------------------------
        | Migrate Old Data
        |--------------------------------------------------------------------------
        */

        DB::table('tickets')
            ->where('status', 'open')
            ->update([
                'status' => 'waiting_for_support',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Copy old reply time if column exists
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('tickets', 'last_replied_at')) {

            DB::table('tickets')
                ->whereNull('last_message_at')
                ->update([
                    'last_message_at' => DB::raw(
                        'COALESCE(last_replied_at, updated_at)'
                    ),
                ]);

        } else {

            DB::table('tickets')
                ->whereNull('last_message_at')
                ->update([
                    'last_message_at' => DB::raw('updated_at'),
                ]);
        }
    }


    public function down(): void
    {
        Schema::table('ticket_messages', function (Blueprint $table) {

            if (Schema::hasColumn('ticket_messages', 'sender_type')) {
                $table->dropColumn('sender_type');
            }
        });


        Schema::table('tickets', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('tickets', 'priority')) {
                $columns[] = 'priority';
            }

            if (Schema::hasColumn('tickets', 'last_message_at')) {
                $columns[] = 'last_message_at';
            }

            if (Schema::hasColumn('tickets', 'closed_at')) {
                $columns[] = 'closed_at';
            }

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
