<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming
* @method void __construct(Games $game, SlotsIterator $actions, Int $type = 0)
* @method void makeAction(Slot $slot, GameActions $action)
*/

namespace App\Gaming;

use App\Games;
use App\GameActions;
use App\Gaming\Abstracts\PlayerAbstract;
use App\Gaming\Abstracts\SlotsIteratorAbstract;

class Player extends PlayerAbstract
{
	public function __construct(Games $game, SlotsIteratorAbstract $actions, Int $type = 0)
	{
		if ($type > 1 || $type < 0) {
			throw new Exception("Type must be 0 for human or 1 for computer");
		}
		$this->game = $game;
		$this->actions = $actions;
		$this->type = $type;
	}
	public function makeAction(Slot $slot, GameActions $action):void
	{
		$action->game_id = $this->game->id;
		$action->player = (string) $this->type();
		$action->position_x = (string) $slot->position_x;
		$action->position_y = (string) $slot->position_y;
		$action->save();
	}

}