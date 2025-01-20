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
        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
           
            $table->string('Name', 255);
            $table->text('Address');
            $table->string('ContactNumber', 15);
            $table->string('Email', 255)->nullable()->unique();
            $table->decimal('Latitude', 10, 8)->nullable();
            $table->decimal('Longitude', 11, 8)->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        

            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};
