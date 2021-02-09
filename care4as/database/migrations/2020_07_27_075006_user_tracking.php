<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_tracking', function (Blueprint $table) {
          $table->id('id');
          $table->integer('user_id');
          $table->integer('calls')->default(0);
          $table->integer('save')->default(0);
          $table->integer('cancel')->default(0);
          $table->integer('service')->default(0);
          $table->text('type')->default('SSC');
          $table->text('division')->default('Retention');
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
        Schema::dropIfExists('user_tracking');
    }
}
