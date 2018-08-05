<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $table = "games";
    protected $fillable = [
        'player_type',
        'player_id',
        'status',
        'winner',
    ];
    public function actions()
    {
        return$this->hasMany('App\GameActions', 'game_id', 'id');
    }
}