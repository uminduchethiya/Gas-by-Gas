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

            $table->timestamps();

            $table->foreignId('OutletID')->nullable()->constrained('outlets', 'OutletID')->onDelete('set null');

            $table->foreignId('gas_cylinder_id')->nullable()->constrained('gas_cylinders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_plans');
    }
};
