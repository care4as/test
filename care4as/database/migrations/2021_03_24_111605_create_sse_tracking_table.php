<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSseTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sse_tracking', function (Blueprint $table) {
            $table->id();
            $table->date('trackingdate')->nullable();
            $table->text('department')->nullable();
            $table->integer('sse_case_id')->nullable();
            $table->text('sseType')->nullable();
            $table->integer('contract_id')->nullable();
            $table->integer('person_id')->nullable();
            $table->text('Tracking_Item1')->nullable();
            $table->text('Tracking_Item2')->nullable();
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
        Schema::dropIfExists('sse_tracking');
    }
}
