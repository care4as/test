<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRetentionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retention_details', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->date('call_date');
            $table->text('department_desc');
            $table->integer('calls')->nullable();
            $table->integer('calls_smallscreen')->nullable();
            $table->integer('calls_bigscreen')->nullable();
            $table->integer('calls_portale')->nullable();
            $table->integer('orders')->nullable();
            $table->integer('orders_smallscreen')->nullable();
            $table->integer('orders_bigscreen')->nullable();
            $table->integer('orders_portale')->nullable();
            $table->decimal('Rabatt_Guthaben_Brutto_Mobile')->nullable();
            $table->integer('mvlzNeu')->nullable();
            $table->integer('rlzPlus')->nullable();
            $table->unique(['call_date','person_id']);
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
        Schema::dropIfExists('retention_details');
    }
}
