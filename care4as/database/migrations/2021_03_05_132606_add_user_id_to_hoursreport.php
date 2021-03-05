<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToHoursreport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hoursreport', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hoursreport', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
    }
    // UPDATE hoursreport SET user_id = (SELECT users.id, users.lastname from users where users.lastname = (Select SUBSTRING_INDEX(`hoursreport`.`name`,',',1) FROM hoursreport Where SUBSTRING_INDEX(`hoursreport`.`name`,',',1) = users.lastname GROUP By SUBSTRING_INDEX(`hoursreport`.`name`,',',1)))
    // UPDATE hoursreport INNER JOIN users  ON SUBSTRING_INDEX(`hoursreport`.`name`,',',1) = users.lastname set hoursreport.user_id = users.id
}
