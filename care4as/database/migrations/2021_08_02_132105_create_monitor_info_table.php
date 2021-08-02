<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitorInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitor_info', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('size')->nullable();
            $table->text('brand')->nullable();
            $table->text('modellnumber')->nullable();
            $table->text('ports')->nullable();
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
        Schema::dropIfExists('monitor_info');
    }
}
