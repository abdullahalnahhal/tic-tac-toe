<?php
/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Http\Controllers\Api
* @method index(Request $request)
* @method void humanPlay(Players $player_info, Gaming $game , Board $board, Slot $slot)
* @method void computerPlay(Players $player_info, Gaming $game , Board $board)
*/
namespace App\Http\Controllers;

use App\Players;
use App\Games;

class HomeController extends Controller
{
    public function index()
    {
    	$player = $this->startGame();
        return view("index", [
            'token'=>$player->token
        ]);
    }
    private function startGame()
    {
        $player = new Players;
        $game = new Games;
        $player->token = newToken();
        $player->save();
        $game->player_id = $player->id;
        $game->save();
        return $player;
    }
}
