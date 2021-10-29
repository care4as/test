<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->rememberToken();
            $table->string('name');
            $table->string('password')->default(Hash::make('care4as2021!'));
            $table->string('role')->nullable();
            $table->integer('status')->default(0);
            $table->string('mail')->nullable();
            $table->timestamp('mail_verified_at')->nullable();           
            $table->integer('ds_id')->unique();
            $table->string('project')->nullable();
            $table->string('department')->nullable();
            $table->string('team')->nullable();
            $table->integer('1u1_person_id')->nullable();
            $table->integer('1u1_agent_id')->nullable();
            $table->string('1u1_sse_name')->nullable();
            $table->integer('kdw_tracking_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
