<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id'); 
            $table->unsignedBigInteger('gas_cylinder_id'); 
            $table->integer('quantity'); 
            $table->integer('isActive')->default(1); 
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('gas_cylinder_id')->references('id')->on('gas_cylinders')->onDelete('cascade');
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
