<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pc_info', function (Blueprint $table) {
            $table->id();
            // $table->text('name');
            $table->text('cpu_family')->nullable();
            $table->text('cpu')->nullable();
            $table->text('port')->nullable();
            $table->text('speed')->nullable();
            $table->text('brand')->nullable();
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
        Schema::dropIfExists('pc_info');
    }
}
