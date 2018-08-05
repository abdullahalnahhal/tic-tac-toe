<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming\Abstracts
* @method void __construct(Players $player)
* @method void initHumanSlots(Players $player , SlotsIterator $slots)
* @method void initComputerSlots(Players $player , SlotsIterator $slots)
* @method void initFreeSlots(Players $player , SlotsIterator $slots)
* @method void addHumanSlot(Slot $slot)
* @method void addComputerSlot(Slot $slot)
* @method void removeFreeSlot(Slot $slot)
* @method bool isFreeSlot(Slot $slot)
* @method bool isColumn(Slot $slot)
* @method bool isRow(Slot $slot)
* @method bool isRDiag(Slot $slot)
* @method bool isLDiag(Slot $slot)
*/

namespace App\Gaming;

use App\Players;
use App\Gaming\Slot;
use App\Gaming\Abstracts\BoardAbstract;
use App\Gaming\Abstracts\SlotsIteratorAbstract;

class Board extends BoardAbstract
{
	public function __construct(Players $player)
	{
		$this->initHumanSlots($player, new SlotsIterator);
		$this->initComputerSlots($player, new SlotsIterator);
		$this->initFreeSlots($player, new SlotsIterator);
	}
	protected function initHumanSlots(Players $player, SlotsIteratorAbstract $slots):void
	{
		foreach ($player->game->actions->where('player', 0) as $key => $value) {
			$slots->slot = new Slot($value->position_x, $value->position_y);
		}
		$this->player_slots = $slots;
	}
	protected function initComputerSlots(Players $player, SlotsIteratorAbstract $slots):void
	{
		foreach ($player->game->actions->where('player', 1) as $key => $value) {
			$slots->slot = new Slot($value->position_x, $value->position_y);
		}
		$this->computer_slots = $slots;
	}
	protected function initFreeSlots(Players $player, SlotsIteratorAbstract $slots):void
	{
		for ($i = 0; $i <= 2; $i++) { 
			for ($j = 0; $j <= 2; $j++) { 
				$add = true;
				foreach ($this->player_slots as $key => $value) {
					if ($value->position_x == $i && $value->position_y == $j) {
						$add = false;
						continue;
					}
				}

				if ($add) {
					foreach ($this->computer_slots as $key => $value) {
						if ($value->position_x == $i && $value->position_y == $j) {
							$add = false;
							continue;
						}
					}
				}
				
				if ($add) {
					$slots->slot = new Slot($i, $j);
				}
			}
		}
		$this->free_slots = $slots;
	}
	public function addHumanSlot(Slot $slot):void
	{
		$this->playerSlots()->slot = $slot; 
	}
	public function addComputerSlot(Slot $slot):void
	{
		$this->computerSlots()->slot = $slot; 
	}
	public function removeFreeSlot(Slot $slot):void
	{
		foreach ($this->freeSlots() as $key => $value) {
			if ($value->position_x == $slot->position_x && $value->position_y == $slot->position_y) {
				$this->freeSlots()->unset($key);
			}
		}
	}
	public function isFreeSlot(Slot $slot):bool
	{
		$free = false;
		foreach ($this->freeSlots()->source() as $key => $value) {
			if ($value->position_x == $slot->position_x && 
				$value->position_y == $slot->position_y) {
				$free = true;
				break;
			}
		}
		return $free;
	}
	public function isRow(SlotsIteratorAbstract $slots):bool
	{
		$return = false;
		foreach ($slots as $key => $value1) {
			$count = 1;
			foreach ($slots as $key2 => $value2) {
				if ($key != $key2 && $value1->position_y == $value2->position_y) {
					$count++;
				}
			}
			if ($count == 3) {
				return true;
			}
		}
		return $return;
	}
	public function isColumn(SlotsIteratorAbstract $slots):bool
	{
		$return = false;
		foreach ($slots as $key => $value1) {
			$count = 1;
			$win_slots = [];
			foreach ($slots as $key2 => $value2) {
				if ($key != $key2 && $value1->position_x == $value2->position_x) {
					$win_slots[] = ['x'=>$value1->position_x , 'y'=>$value1->position_y];
					$count++;
				}
			}
			if ($count == 3) {
				return true;
			}
		}
		return $return;
	}
	public function isLDiag(SlotsIteratorAbstract $slots):bool
	{
		$count = 0;
		foreach ($slots as $key => $value1) {
			if ($value1->position_x == $value1->position_y) {
				$win_slots[] = ['x'=>$value1->position_x , 'y'=>$value1->position_y];
				$count++;
			}
		}
		if ($count == 3) {
			$this->win_slots = $win_slots;
			return true;
		}
		return false;
	}
	public function isRDiag(SlotsIteratorAbstract $slots):bool
	{
		$count = 0;
		foreach ($slots as $key => $value) {
			if ($value->position_x == $value->position_y && $value->position_y == 1) {
				$win_slots[] = ['x'=>$value->position_x , 'y'=>$value->position_y];
				$count++;
			}
			if ($value->position_x == 0 && $value->position_y == 2) {
				$win_slots[] = ['x'=>$value->position_x , 'y'=>$value->position_y];
				$count++;
			}
			if ($value->position_x == 2 && $value->position_y == 0) {
				$win_slots[] = ['x'=>$value->position_x , 'y'=>$value->position_y];
				$count++;
			}
		}
		if ($count == 3) {
			$this->win_slots = $win_slots;
			return true;
		}
		return false;
	}
}