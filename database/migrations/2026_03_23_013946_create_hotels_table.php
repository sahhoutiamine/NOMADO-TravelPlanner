<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('price_per_night', 8, 2);
            $table->text('description');
            $table->string('localisation')->nullable(); // Format: "latitude, longitude"
            $table->string('contact_number');
            $table->string('email');
            $table->enum('type', ['luxury', 'mid-range', 'economy', 'budget', 'boutique', 'resort']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};