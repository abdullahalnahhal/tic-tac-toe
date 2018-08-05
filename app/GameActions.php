<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameActions extends Model
{
	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $table = "game_actions";
    protected $fillable = [
        'game_id',
        'player',
        'position_x',
        'position_y',
    ];
}