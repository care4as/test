<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyagentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyagent', function (Blueprint $table) {
            $table->id();
            $table->datetime('date')->nullable();
            $table->integer('kw')->nullable()->default(0);
            $table->string('dialog_call_id')->nullable()->default(0);
            $table->integer('agent_id')->nullable()->default(0);
            $table->string('agent_login_name')->nullable()->default(0);
            $table->string('agent_name')->nullable()->default(0);
            $table->integer('agent_group_id')->nullable()->default(0);
            $table->string('agent_group_name')->nullable()->default(0);
            $table->integer('agent_team_id')->nullable()->default(0);
            $table->string('agent_team_name')->nullable()->default(0);
            $table->integer('queue_id')->nullable()->default(0);
            $table->string('queue_name')->nullable()->default(0);
            $table->integer('skill_id')->nullable()->default(0);
            $table->string('skill_name')->nullable()->default(0);
            $table->string('status')->nullable()->default(0);
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->integer('time_in_state')->nullable()->default(0);
            $table->string('timezone')->nullable();
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
        Schema::dropIfExists('dailyagent');
    }
}
