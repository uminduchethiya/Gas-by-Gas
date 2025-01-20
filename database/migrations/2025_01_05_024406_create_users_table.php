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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('nic')->unique()->nullable();
           

            $table->rememberToken();
            $table->boolean('isActive')->default(true);
            $table->timestamp('email_verified_at')->nullable();

            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('outlet_id')->nullable();

            $table->foreign('role_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
        

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
