<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropIndex(['trip_type']);
            $table->dropColumn('trip_type');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->enum('trip_type', ['adventure', 'culture', 'beach', 'romantic', 'nature', 'shopping'])
                ->after('city')
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropIndex(['trip_type']);
            $table->dropColumn('trip_type');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->enum('trip_type', ['adventure', 'culture', 'beach', 'romantic', 'nature', 'shopping'])
                ->after('name')
                ->index();
        });
    }
};
