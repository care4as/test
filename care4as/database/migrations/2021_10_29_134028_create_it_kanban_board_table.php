<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItKanbanBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_kanban_board', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('reviser')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.. 
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('it_kanban_board');
    }
}
