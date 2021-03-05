<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEobmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eobmails', function (Blueprint $table) {
            $table->id();
            $table->date('datum');
            $table->integer('servicelevel')->nullable();
            $table->integer('erreichbarkeit')->nullable();
            $table->integer('Abnahme')->nullable();
            $table->integer('IV_Erfüllung')->nullable();
            $table->text('Comments')->nullable();
            $table->integer('Abteilung')->nullable();
            $table->integer('CR GeVo')->nullable();
            $table->integer('SSC CR')->nullable();
            $table->text('Cancels')->nullable();
            $table->boolean('send')->default(0);
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
        Schema::dropIfExists('eobmail');
    }
}
