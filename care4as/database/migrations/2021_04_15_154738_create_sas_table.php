<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->date('date');
            $table->char('topic', 40)->nullable();
            $table->char('serviceprovider_place', 40)->nullable();
            $table->integer('person_id');
            $table->integer('contract_id');
            $table->char('case', 40)->default('Neubestellung')->nullable();
            $table->char('productgroup', 40)->nullable();
            $table->char('productcluster', 40)->nullable();
            $table->integer('GO_Prov')->nullable();
            $table->unique(['order_id','person_id','GO_Prov']);

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
        Schema::dropIfExists('sas');
    }
}
