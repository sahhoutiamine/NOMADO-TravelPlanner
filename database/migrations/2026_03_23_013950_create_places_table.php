<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('localisation')->nullable(); // Format: "latitude, longitude"
            $table->decimal('min_price', 10, 2)->default(150.00);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};