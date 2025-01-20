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
            
            $table->integer('quantity'); 
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->unsignedBigInteger('outlet_id'); 
            $table->unsignedBigInteger('gas_cylinder_id');  
            
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            $table->foreign('gas_cylinder_id')->references('id')->on('gas_cylinders')->onDelete('cascade');
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
