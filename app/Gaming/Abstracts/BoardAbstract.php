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
* @method SlotsIterator playerSlots()
* @method SlotsIterator computerSlots()
* @method SlotsIterator freeSlots()
* @property SlotsIterator $player_slots
* @property SlotsIterator $computer_slots
* @property SlotsIterator $free_slots
*/

namespace App\Gaming\Abstracts;

use App\Players;
use App\Gaming\Slot;

abstract class BoardAbstract
{
	protected $player_slots;
	protected $computer_slots;
	protected $free_slots;
    protected $win_slots;
    abstract public function __construct(Players $player);
    abstract protected function initHumanSlots(Players $player , SlotsIteratorAbstract $slots):void;
    abstract protected function initComputerSlots(Players $player , SlotsIteratorAbstract $slots):void;
    abstract protected function initFreeSlots(Players $player , SlotsIteratorAbstract $slots):void;
    abstract public function addHumanSlot(Slot $slot):void;
    abstract public function addComputerSlot(Slot $slot):void;
    abstract public function removeFreeSlot(Slot $slot):void;
    abstract public function isFreeSlot(Slot $slot):bool;
    abstract public function isColumn(SlotsIteratorAbstract $slots):bool;
    abstract public function isRow(SlotsIteratorAbstract $slots):bool;
    abstract public function isRDiag(SlotsIteratorAbstract $slots):bool;
    abstract public function isLDiag(SlotsIteratorAbstract $slots):bool;

    public function playerSlots():SlotsIteratorAbstract
    {
    	return $this->player_slots;
    }
    public function computerSlots():SlotsIteratorAbstract
    {
    	return $this->computer_slots;
    }
    public function freeSlots():SlotsIteratorAbstract
    {
        return $this->free_slots;
    }
    public function winSlots():SlotsIteratorAbstract
    {
        return $this->free_slots;
    }
}