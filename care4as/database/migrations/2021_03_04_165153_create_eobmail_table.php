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
            $table->integer('krankenquote')->nullable();
            $table->integer('abnahme')->nullable();
            $table->integer('iv_erfuellung')->nullable();
            $table->integer('abteilung')->nullable();
            $table->integer('gevocr')->nullable();
            $table->integer('ssccr')->nullable();
            $table->text('cancelcauses')->nullable();
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
