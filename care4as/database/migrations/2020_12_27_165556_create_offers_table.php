<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('volume');
            $table->text('telefon');
            $table->text('price');
            $table->boolean('BK')->nullable();
            $table->boolean('NK')->nullable();
            $table->boolean('Special')->nullable();
            $table->boolean('Cyber')->nullable();
            $table->boolean('Beginner')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
