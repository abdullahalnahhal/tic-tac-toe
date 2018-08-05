<?php
/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Http\Controllers\Api
* @method index(Request $request)
* @method void humanPlay(Players $player_info, Gaming $game , Board $board, Slot $slot)
* @method void computerPlay(Players $player_info, Gaming $game , Board $board)
*/
namespace App\Http\Controllers\Api;

use App\Players;
use App\GameActions;
use App\Gaming\Board;
use App\Gaming\Slot;
use App\Gaming\Gaming;
use App\Gaming\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PlayRequest;
use App\Http\Controllers\Controller;
use App\Gaming\Interfaces\GamingInterface;
use App\Gaming\Abstracts\BoardAbstract;
use App\Gaming\Abstracts\SlotsIteratorAbstract;

class PlayController extends Controller
{
    public function index(Request $request)
    {
    	$player = $request->user();
    	$slot = new Slot($request->all()['position_x'], $request->all()['position_y']);
    	$board = new Board($player);
    	$game = new Gaming();
    	$is_available = $board->isFreeSlot($slot);
    	if ($is_available) {
    		return response()->json($this->play($player, $game, $board, $slot));
    	}
        return response()->json($this->mssages('invalid', $slot));
    }

    private function Play(Players $player, Gaming $game, BoardAbstract $board, Slot $slot)
    {
        $this->humanPlay($player, $game, $board, $slot);

        $is_game_ended = $this->winOrLoose($board, $game, $player);
        if ($is_game_ended) {
            return $is_game_ended;
        }
        $computer = $this->computerPlay($player, $game, $board);
        $is_game_ended = $this->winOrLoose($board, $game, $player, $computer);
        if ($is_game_ended) {
            return $is_game_ended;
        }        
        return $this->mssages('new', $computer);
    }

    public function winOrLoose(BoardAbstract $board, Gaming $game, Players $player, Slot $slot = null)
    {
        $is_win = false;
        $is_loose = false;
        $is_over = false;
        // is win
        if ($board->playerSlots()->count() >= 3 ) {
            $is_win = $game->isWin($board, $board->playerSlots());
        }
        if ($is_win) {
            $player->game->status =1;
            $player->game->winner =1;
            return $this->mssages('win', null, $board->winSlots());
        }
        // is loose 
        if ($board->computerSlots()->count() >= 3 ) {
            $is_loose = $game->isLoose($board, $board->computerSlots());
        }

        if ($is_loose) {
            $player->game->status =1;
            $player->game->save();
            return $this->mssages('loose', $slot, $board->winSlots());
            
        }
        // is over
        if ($board->freeSlots()->count() == 0) {
            $is_over = true;
            $player->game->status =1;
            $player->game->save();
            return $this->mssages('game_over');
        }

        return false;

    }

    private function humanPlay(Players $player_info, GamingInterface $game , BoardAbstract $board, Slot $slot)
    {
    	$action = new GameActions();
    	$player = new Player($player_info->game, $board->playerSlots(), 0);
    	$game->humanPlay($player, $board, $slot, $action);
    }

    private function computerPlay(Players $player_info, GamingInterface $game , BoardAbstract $board)
    {
    	$action = new GameActions();
    	$player = new Player($player_info->game, $board->playerSlots(), 1);
    	$slot = $board->freeSlots()->rand(1);
    	$is_available = $board->isFreeSlot($slot);
    	if ($is_available) {
    		$game->computerPlay($player, $board, $slot, $action);
    	}
        return $slot;
    }

    private function mssages(String $message_title, Slot $slot = null, SlotsIteratorAbstract $slots = null)
    {
        if ($slot) {
            $slot = ['x'=>$slot->position_x ,'y'=>$slot->position_y];
        }
        if ($slots) {
            $new_slots = [];
            foreach ($slots->source() as $value) {
                $new_slots[] = ['x'=>$value->position_x ,'y'=>$value->position_y];
            }
            $slots = $new_slots;
        }
        $message = [
            'win' =>[
                'status'=> 'win',
                'slots'=>$slots
            ],
            'loose' =>[
                'status'=> 'loose',
                'slots'=>$slots,
                'slot'=>$slot
            ],
            'game_over' =>[
                'status'=> 'game_over',
            ],
            'invalid'=>[
                'status' => 'invalid',
                'slot' => $slot
            ],
            'new'=>[
                'status' => 'new',
                'slot' => $slot
            ],
        ];
        return $message[$message_title];
    }
}
