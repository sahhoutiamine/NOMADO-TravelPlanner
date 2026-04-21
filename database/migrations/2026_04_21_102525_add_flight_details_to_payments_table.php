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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('airline')->nullable();
            $table->string('flight_departure')->nullable();
            $table->string('flight_arrival')->nullable();
            $table->string('flight_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['airline', 'flight_departure', 'flight_arrival', 'flight_duration']);
        });
    }
};
