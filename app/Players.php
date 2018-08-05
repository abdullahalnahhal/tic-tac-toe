<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $table = "players";
    protected $fillable = [
        'token',
    ];

    public static function getByToken($token)
    {
    	$player = self::where('token', $token)->first();
    	return $player;
    }

    public function game()
    {
        return $this->belongsTo('App\Games', 'id', 'player_id');
    }

}