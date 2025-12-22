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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            // User link foreign key 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('address');
            
            // Google Maps latitude & longitude (Precision  10,7)
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            
            // Request  status 
            $table->enum('status', ['pending', 'assigned', 'completed'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};