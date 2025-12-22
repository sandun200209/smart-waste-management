<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade'); // Driver reference
            $table->json('route_points'); // Route latitude & longitude points as JSON
            $table->decimal('total_distance', 8, 2); // Distance in km
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
