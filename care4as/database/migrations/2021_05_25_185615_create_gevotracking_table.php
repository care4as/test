<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGevotrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gevotracking', function (Blueprint $table) {
            $table->id();
            $table->text('department_desc');
            $table->text('change_cluster');
            $table->integer('contract_id';
            $table->text('business_transaction_desc');
            $table->integer('person_id');
            $table->text('Ziel_LZV');
            $table->id('has_cancellation_ind';
            $table->id('contract_period_impact';
            $table->id('Order_Retention';
            $table->id('Order_Prevention';
            $table->id('Ziel_Welt_Bezeichnung';

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
        Schema::dropIfExists('gevotracking');
    }
}
