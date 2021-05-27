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
            $table->integer('order_id');
            $table->date('date');
            $table->text('change_cluster');
            $table->integer('contract_id');
            $table->text('business_transaction_desc');
            $table->integer('person_id');
            $table->text('Ziel_LZV');
            $table->integer('has_cancellation_index');
            $table->text('contract_period_impact');
            $table->integer('Order_Retention');
            $table->integer('Order_Prevention');
            $table->text('Ziel_Welt_Bezeichnung');

            $table->timestamps();
            $table->unique(['date','person_id']);
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
