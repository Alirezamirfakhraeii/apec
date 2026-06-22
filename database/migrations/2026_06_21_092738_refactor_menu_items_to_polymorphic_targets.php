<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->nullableMorphs('target');
            $table->string('route_name')->nullable()->after('url');
            $table->json('route_params')->nullable()->after('route_name');
            $table->string('icon')->nullable()->after('route_params');
            $table->boolean('open_in_new_tab')->default(false)->after('position');
        });

        if (Schema::hasColumn('menu_items', 'category_id')) {
            DB::table('menu_items')
                ->where('type', 'category')
                ->whereNotNull('category_id')
                ->update([
                    'target_type' => Category::class,
                    'target_id' => DB::raw('category_id'),
                ]);

            Schema::table('menu_items', function (Blueprint $table) {
                try {
                    $table->dropForeign(['category_id']);
                } catch (\Throwable $e) {
                    //
                }

                $table->dropColumn('category_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('url');
        });

        DB::table('menu_items')
            ->where('target_type', Category::class)
            ->whereNotNull('target_id')
            ->update([
                'category_id' => DB::raw('target_id'),
            ]);

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropMorphs('target');
            $table->dropColumn([
                'route_name',
                'route_params',
                'icon',
                'open_in_new_tab',
            ]);
        });
    }
};
