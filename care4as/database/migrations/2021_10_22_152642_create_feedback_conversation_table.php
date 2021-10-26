<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackConversationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_conversation', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->text('agreement')->nullable();
            $table->date('date')->nullable();
            $table->date('changed')->nullable();
            $table->string('overhead_name')->nullable();
            $table->integer('overhead_dsid')->nullable();
            $table->string('agent_name')->nullable();
            $table->integer('agent_dsid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_conversation');
    }
}
