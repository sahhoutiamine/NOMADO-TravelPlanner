<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('flight_airline')->nullable()->after('departure_city_id');
            $table->string('flight_class')->nullable()->after('flight_airline');
            $table->decimal('flight_price', 10, 2)->nullable()->after('flight_class');
            $table->string('flight_duration')->nullable()->after('flight_price');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['flight_airline', 'flight_class', 'flight_price', 'flight_duration']);
        });
    }
};
