<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMabelcausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mabelcauses', function (Blueprint $table) {
            $table->id();
            $table->integer('WhoDidIt');
            $table->text('ContractID');
            $table->text('WhoGotIt');
            $table->text('WhyBro')->nullable();
            $table->text('category');
            $table->text('productgroup');
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
        Schema::dropIfExists('mabelcauses');
    }
}
