<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlet_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('maxTokens');
            $table->integer('currentTokens');
            $table->unsignedBigInteger('OutletID'); 
            $table->foreign('OutletID')->references('OutletID')->on('outlets')->onDelete('cascade'); 
            $table->foreignId('gas_cylinder_id')->nullable()->constrained('gas_cylinders')->onDelete('set null');
            $table->decimal('token_amount', 10, 2)->default(0.00);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlet_tokens');
    }
}
