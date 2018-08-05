<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_actions', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->enum("player", [0, 1])->comment("0 for human 1 for computer");
            $table->enum("position_x", [0, 1, 2])->comment("these for any vertical slot number");
            $table->enum("position_y", [0, 1, 2])->comment("these for any horizontal slot number");
            $table->timestamps();
            // add foreign key
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_actions');
    }
}
