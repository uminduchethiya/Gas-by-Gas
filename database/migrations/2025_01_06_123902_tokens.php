<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->enum('status', [
                'pending', 
                'scheduled', 
                'delivered', 
                'canceled', 
                'reasigned', 
                'cylinder_received', 
                'payment_complete'
            ])->default('pending');
            $table->boolean('isActive')->default(true);
            $table->string('description')->nullable();

            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('cylinder_type_id'); 
            $table->unsignedBigInteger('branch_id'); 
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cylinder_type_id')->references('id')->on('gas_cylinders')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->timestamps();

        
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
