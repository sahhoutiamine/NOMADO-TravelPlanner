<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('trip_type');
            $table->decimal('budget_total', 10, 2);
            $table->date('departure_date')->nullable();
            $table->integer('duration');
            $table->integer('passengers');
            $table->decimal('flight_budget', 10, 2);
            $table->decimal('hotel_budget', 10, 2);
            $table->decimal('activities_budget', 10, 2);
            $table->decimal('misc_budget', 10, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->string('share_code', 6)->nullable()->unique();
            $table->text('selected_place_ids')->nullable();
            $table->boolean('include_hotel')->default(true);
            $table->foreignId('departure_city_id')->nullable()->constrained('cities');
            $table->string('flight_airline')->nullable();
            $table->string('flight_class')->nullable();
            $table->string('flight_duration')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_hotel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_hotel');
        Schema::dropIfExists('bookings');
    }
};
