<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_inventory', function (Blueprint $table) {
            $table->id();
            $table->text('device_id');
            $table->text('type_id');
            $table->text('place')->nullable();
            $table->text('name')->nullable();
            $table->text('floor')->nullable();
            $table->text('comment')->nullable();
            $table->text('description')->nullable();
            $table->text('serialnumber')->nullable();
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
        Schema::dropIfExists('hardware_inventory');
    }
}
