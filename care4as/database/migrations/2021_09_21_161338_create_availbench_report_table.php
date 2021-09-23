<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailbenchReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availbench_report', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('date_key')->nullable();
            $table->date('date_date')->nullable();
            $table->timestamp('call_date_interval_start_time')->nullable();
            $table->integer('call_forecast_issue_key')->nullable();
            $table->string('call_forecast_issue')->nullable();
            $table->integer('call_forecast_owner_key')->nullable();
            $table->string('call_forecast_owner')->nullable();
            $table->integer('forecast')->nullable();
            $table->integer('handled')->nullable();
            $table->integer('availtime_summary')->nullable();
            $table->integer('availtime_sec')->nullable();
            $table->integer('handling_time_sec')->nullable();
            $table->double('availtime_percent')->nullable();
            $table->double('forecast_rate')->nullable();
            $table->double('avail_bench')->nullable();
            $table->integer('idp_done')->nullable();
            $table->double('number_payed_calls')->nullable();
            $table->double('price')->nullable();
            $table->double('aht')->nullable();
            $table->double('productive_minutes')->nullable();
            $table->double('malus_interval')->nullable();
            $table->double('malus_percent')->nullable();
            $table->double('acceptance_rate')->nullable();
            $table->double('total_costs_per_interval')->nullable();
            $table->integer('malus_approval_done')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availbench_report');
    }
}
