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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('trip_type');
            $table->decimal('budget_total', 10, 2);
            $table->integer('duration');
            $table->integer('passengers');
            $table->decimal('flight_budget', 10, 2);
            $table->decimal('hotel_budget', 10, 2);
            $table->decimal('activities_budget', 10, 2);
            $table->decimal('misc_budget', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
