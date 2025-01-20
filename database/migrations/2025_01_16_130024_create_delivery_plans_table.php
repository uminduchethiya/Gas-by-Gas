<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_plans', function (Blueprint $table) {
            $table->id();

            $table->date('DeliveryDate');

            $table->integer('QuantityPlanned');
            $table->integer('QuantityReceived')->nullable();

            $table->enum('Status', ['Pending', 'In_Transit', 'Delivered', 'Discrepancy','Completed'])->default('Pending');

            $table->text('Notes')->nullable();
            $table->boolean('isActive')->default(true);

            $table->unsignedBigInteger('cylinder_type_id'); 
            $table->unsignedBigInteger(column: 'outlet_id'); 



            $table->foreign('cylinder_type_id')->references('id')->on('gas_cylinders')->onDelete('cascade');
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
         


            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_plans');
    }
};
