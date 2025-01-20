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
                'cylinder_received',
                'payment_complete',
                'complete', 
                'canceled', 
                'reassigned'
            ])->default('pending');
            $table->boolean('isActive')->default(true);
            $table->text('description')->nullable();
        
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('cylinder_type_id'); 
            $table->unsignedBigInteger(column: 'outlet_id'); 
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cylinder_type_id')->references('id')->on('gas_cylinders')->onDelete('cascade');
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
        
            $table->integer('quantity')->default(1);
            $table->timestamp('expires_at')->nullable();
            $table->string('token_code')->unique()->nullable();
        
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        
            $table->timestamps();
            $table->softDeletes();
        
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
