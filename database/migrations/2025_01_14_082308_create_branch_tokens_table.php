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

            $table->unsignedBigInteger('cylinder_type_id'); 
            $table->unsignedBigInteger(column: 'outlet_id'); 

            $table->foreign('cylinder_type_id')->references('id')->on('gas_cylinders')->onDelete('cascade');
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
         
            $table->boolean('isActive')->default(true);

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
