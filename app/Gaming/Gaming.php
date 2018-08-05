<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming
* @method void humanPlay(Player $player, Board $board, Slot $slot, GameActions $actions)
* @method void computerPlay(Player $player, Board $board, Slot $slot, GameActions $actions)
* @method bool isWin(Board $board, SlotsIterator $slots)
* @method bool isLoose(Board $board, SlotsIterator $slots)
*/

namespace App\Gaming;

use App\Players;
use App\GameActions;
use App\Gaming\Interfaces\GamingInterface;
use App\Gaming\Abstracts\BoardAbstract;
use App\Gaming\Abstracts\PlayerAbstract;
use App\Gaming\Abstracts\SlotsIteratorAbstract;

class Gaming Implements GamingInterface
{
	public function humanPlay(PlayerAbstract $player, BoardAbstract $board, Slot $slot, GameActions $actions):void
	{
		$player->makeAction($slot, $actions);
		$board->addHumanSlot($slot);
    	$board->removeFreeSlot($slot);
	}

	public function computerPlay(PlayerAbstract $player, BoardAbstract $board, Slot $slot, GameActions $actions):void
	{
		$player->makeAction($slot, $actions);
		$board->addComputerSlot($slot);
		$board->removeFreeSlot($slot);
	}

	public function isWin(BoardAbstract $board, SlotsIteratorAbstract $slots):bool
	{
		if ($board->isColumn($slots)) {
			return true;
		}
		if ($board->isRow($slots)) {
			return true;
		}
		if ($board->isRDiag($slots)) {
			return true;
		}
		if ($board->isLDiag($slots)) {
			return true;
		}
		return false;
	}

	public function isLoose(BoardAbstract $board, SlotsIteratorAbstract $slots):bool
	{
		if ($board->isColumn($slots)) {
			return true;
		}
		if ($board->isRow($slots)) {
			return true;
		}
		if ($board->isRDiag($slots)) {
			return true;
		}
		if ($board->isLDiag($slots)) {
			return true;
		}
		return false;
	}
}