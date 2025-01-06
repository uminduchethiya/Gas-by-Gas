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
        Schema::create('token_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('token_id');
            $table->foreign('token_id')->references('id')->on('tokens')->onDelete('cascade');
            $table->enum('currentStatus', [
                'pending', 
                'scheduled', 
                'delivered', 
                'canceled', 
                'reasigned', 
                'cylinder_received', 
                'payment_complete'
            ]);
            $table->enum('updateStatus', [
                'pending', 
                'scheduled', 
                'delivered', 
                'canceled', 
                'reasigned', 
                'cylinder_received', 
                'payment_complete'
            ]);
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_histories');
    }
};
