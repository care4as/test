<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursreportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoursreport', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('name');
            $table->decimal('IST');
            $table->decimal('vacation');
            $table->decimal('SA');
            $table->decimal('sick');
            $table->decimal('IST_Angepasst');
            $table->decimal('vacation_Angepasst');
            $table->decimal('SA_Angepasst');
            $table->decimal('sick_Angepasst');
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
        Schema::dropIfExists('hoursreport');
    }
}
