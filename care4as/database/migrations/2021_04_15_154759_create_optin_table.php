<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optin', function (Blueprint $table) {
            $table->id();
            $table->datetime('date');
            $table->char('department',40)->nullable();
            $table->integer('person_id');
            $table->integer('Anzahl_Handled_Calls')->nullable();
            $table->integer('Anzahl_Handled_Calls_ohne_Call-OptIn')->nullable();
            $table->integer('Anzahl_Handled_Calls_ohne_Daten-OptIn')->nullable();
            $table->integer('Anzahl_OptIn-Abfragen')->nullable();
            $table->integer('Anzahl_OptIn-Erfolg')->nullable();
            $table->integer('Anzahl_Call_OptIn')->nullable();
            $table->integer('Anzahl_Global_OptIn')->nullable();
            $table->integer('Anzahl_Email_OptIn')->nullable();
            $table->integer('Anzahl_Print_OptIn')->nullable();
            $table->integer('Anzahl_SMS_OptIn')->nullable();
            $table->integer('Anzahl_Nutzungsdaten_OptIn')->nullable();
            $table->integer('Anzahl_Verkehrsdaten_OptIn')->nullable();
            $table->integer('Anzahl_Call_OptOut')->nullable();
            $table->integer('Anzahl_Email_OptOut')->nullable();
            $table->unique(['date','person_id']);
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
        Schema::dropIfExists('optin');
    }
}
