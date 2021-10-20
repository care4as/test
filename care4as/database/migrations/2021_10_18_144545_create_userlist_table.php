<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userlist', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('username');
            $table->string('role')->nullable();
            $table->string('password')->nullable();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('full_name');
            $table->integer('ds_id')->unique();
            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('location')->nullable();
            $table->string('street')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mail')->nullable();
            $table->string('work_location')->nullable();
            $table->string('project')->nullable();
            $table->string('department')->nullable();
            $table->string('team')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('leave_date')->nullable();
            $table->integer('work_hours')->nullable();
            $table->integer('1u1_person_id')->nullable();
            $table->integer('1u1_agent_id')->nullable();
            $table->string('1u1_sse_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userlist');
    }
}
