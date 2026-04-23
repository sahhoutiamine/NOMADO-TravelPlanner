<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'selected_place_ids')) {
                $table->text('selected_place_ids')->nullable()->after('status');
            }
            if (!Schema::hasColumn('bookings', 'include_hotel')) {
                $table->boolean('include_hotel')->default(true)->after('selected_place_ids');
            }
            if (!Schema::hasColumn('bookings', 'departure_city_id')) {
                $table->foreignId('departure_city_id')->nullable()->constrained('cities')->after('include_hotel');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'selected_place_ids')) {
                $table->dropColumn('selected_place_ids');
            }
            if (Schema::hasColumn('bookings', 'include_hotel')) {
                $table->dropColumn('include_hotel');
            }
            if (Schema::hasColumn('bookings', 'departure_city_id')) {
                $table->dropForeign(['departure_city_id']);
                $table->dropColumn('departure_city_id');
            }
        });
    }
};
