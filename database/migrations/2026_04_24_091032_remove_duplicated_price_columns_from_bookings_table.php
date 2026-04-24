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
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'total_price')) {
                $table->dropColumn('total_price');
            }
            if (Schema::hasColumn('bookings', 'flight_price')) {
                $table->dropColumn('flight_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('flight_price', 10, 2)->nullable();
        });
    }
};
