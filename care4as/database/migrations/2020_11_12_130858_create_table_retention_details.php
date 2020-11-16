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
            $table->integer('calls_handled')->nullable();
            $table->integer('call_handled_Small_Screen')->nullable();
            $table->integer('call_handled_Big_Screen')->nullable();
            $table->integer('call_handled_Mobile_Portale')->nullable();
            $table->integer('Orders_TWVVL_RET')->nullable();
            $table->integer('Orders_TWVVL_SSC_RET')->nullable();
            $table->integer('Orders_TWVVL_Mobile_Portale_RET')->nullable();
            $table->integer('Orders_TWVVL_PREV')->nullable();
            $table->decimal('Rabatt_Guthaben_Brutto_Mobile')->nullable();
            $table->decimal('Rabatt_Guthaben_Brutto_SSC')->nullable();
            $table->decimal('Rabatt_Guthaben_Brutto_BSC')->nullable();
            $table->integer('MVLZ_Mobile')->nullable();
            $table->integer('RLZ_Plus_MVLZ_Mobile')->nullable();
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
