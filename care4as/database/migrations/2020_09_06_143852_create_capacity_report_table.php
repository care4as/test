<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapacityReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacity_report', function (Blueprint $table) {
            $table->id();
            $table->date('target_date');
            $table->integer('duration_days');
            $table->string('workgroup_name');
            $table->string('agent_id');
            $table->string('agent_login_name');
            $table->date('contract_leaving_date')->nullable();
            $table->integer('heads')->nullable();
            $table->integer('new_in_contract_heads')->nullable();
            $table->integer('new_in_workgroup_heads')->nullable();
            $table->integer('leaving_contract_heads')->nullable();
            $table->integer('leaving_workgroup_heads')->nullable();
            $table->string('avg_contract_hrs')->nullable();
            $table->string('avg_min_hrs')->nullable();
            $table->string('avg_max_hrs')->nullable();
            $table->string('staffed_hrs')->nullable();
            $table->string('sickness_hrs')->nullable();
            $table->string('vacation_hrs')->nullable();
            $table->string('training_hrs')->nullable();
            $table->string('meeting_hrs')->nullable();
            $table->string('bank_holiday_hrs')->nullable();
            $table->string('other_absence_hrs')->nullable();
            $table->string('net_hrs')->nullable();
            $table->string('unpaid_hrs')->nullable();
            $table->integer('shift_1_start')->nullable();
            $table->integer('shift_1_stop')->nullable();
            $table->integer('shift_2_start')->nullable();
            $table->integer('shift_2_stop')->nullable();
            $table->integer('shift_3_start')->nullable();
            $table->integer('shift_3_stop')->nullable();
            $table->integer('shift_4_start')->nullable();
            $table->integer('shift_4_stop')->nullable();
            $table->integer('comment')->nullable();
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
        Schema::dropIfExists('capacity_report');
    }
}
