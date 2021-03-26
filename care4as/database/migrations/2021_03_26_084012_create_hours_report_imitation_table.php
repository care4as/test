<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursReportImitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours_report_imitation', function (Blueprint $table) {
            $table->id();
            $table->date('work_date');
            $table->integer('MA_id');
            $table->integer('state_id')->nullable();
            $table->time('work_time_begin')->default('00:00:00');
            $table->time('work_time_end')->default('00:00:00');
            $table->decimal('work_hours',5,3)->default('8.000');
            $table->decimal('pause_hours',4,3)->default('0.000');
            $table->decimal('pay_break_hours',4,3)->default('0.000');
            $table->decimal('over_time_hours',5,3)->default('0.000');
            $table->decimal('pay_hours',5,3)->default('0.000');
            $table->decimal('meeting_hours',4,3)->default('0.000');
            $table->decimal('wc_hours',4,3);
            $table->decimal('drink_hours',4,3);
            $table->decimal('smok_hours',4,3);
            $table->decimal('lunch_hours',4,3);
            $table->decimal('contacts_hours',4,3);

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
        Schema::dropIfExists('hours_report_imitation');
    }
}
