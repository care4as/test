<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNettozeitenimportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nettozeitenimport', function (Blueprint $table) {
            $table->id();
            $table->date('Case Reference Date');
            $table->text('AH3: Department (Agent Hierarchy 3) (Hist)');
            $table->text('AH4: Team (Agent Hierarchy 4) (Hist)');
            $table->text('Source Forecast Issue');
            $table->text('Workpool');
            $table->integer('Agent');
            $table->text('Case Medium');
            $table->integer('Case ID');
            $table->text('Next Case Status');
            $table->integer('Has Call');
            $table->integer('CosmoCom Call Dnis Prefix');
            $table->integer('Is Billing Relevant');
            $table->integer('Is Case created by same Agent');
            $table->integer('Is Nightshift');
            $table->integer('Avg Case Editing Time sec (Limit 1h)');
            $table->integer('Avg SAS Editing Time sec (Limit 1h)');
            $table->integer('Sum Case Editing Time sec (Limit 1h)');
            $table->integer('Sum SAS Editing Time sec (Limit 1h)');
            $table->integer('Sum Case and SAS Editing Time (Limit 1h)');
            $table->integer('Count SSE Case Measurements');
            $table->integer('Count SAS Measurements');
            $table->integer('Count Case and SAS Measurements');

            $table->unique(['Case Reference Date','Case ID','Agent']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nettozeitenimport');
    }
}
