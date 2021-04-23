<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IntermediateStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('intermediate_status', function (Blueprint $table) {
          $table->id();
          $table->datetime('date')->default(now());
          $table->integer('person_id')->default(1);
          $table->integer('SSC_Calls')->nullable();
          $table->integer('BSC_Calls')->nullable();
          $table->integer('Portal_Calls')->nullable();
          $table->integer('PTB_Calls')->nullable();
          $table->integer('KüRü')->nullable();
          $table->integer('Orders')->nullable();
          $table->integer('Calls')->nullable();
          $table->integer('SSC_Orders')->nullable();
          $table->integer('BSC_Orders')->nullable();
          $table->integer('Portal_Orders')->nullable();
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
        Schema::dropIfExists('intermediate_status');
    }
}
