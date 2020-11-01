<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelcausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelcauses', function (Blueprint $table) {
            $table->id();
            $table->string('Customer');
            $table->text('Offer')->nullable();
            $table->text('Notice')->nullable();
            $table->text('Category')->nullable();
            $table->integer('created_by');
            $table->text('status');
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
        Schema::dropIfExists('cancelcauses');
    }
}
