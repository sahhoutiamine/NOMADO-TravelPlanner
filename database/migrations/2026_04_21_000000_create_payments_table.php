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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->string('departure_country')->nullable();
            $table->string('departure_city')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->boolean('is_flight_paid')->default(false);
            $table->boolean('is_hotel_paid')->default(false);
            $table->string('airline')->nullable();
            $table->string('flight_departure')->nullable();
            $table->string('flight_arrival')->nullable();
            $table->string('flight_duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
