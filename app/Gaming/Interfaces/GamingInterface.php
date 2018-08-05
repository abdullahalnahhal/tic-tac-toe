<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming\Interfaces
* @method void humanPlay(Player $player, Board $board, Slot $slot, GameActions $actions)
* @method void computerPlay(Player $player, Board $board, Slot $slot, GameActions $actions)
* @method bool isWin(Board $board, SlotsIterator $slots)
* @method bool isLoose(Board $board, SlotsIterator $slots)
*/

namespace App\Gaming\Interfaces;

use App\Players;
use App\GameActions;
use App\Gaming\Slot;
use App\Gaming\Abstracts\BoardAbstract;
use App\Gaming\Abstracts\PlayerAbstract;
use App\Gaming\Abstracts\SlotsIteratorAbstract;

interface GamingInterface 
{
    public function humanPlay(PlayerAbstract $player, BoardAbstract $board, Slot $slot, GameActions $actions):void;
    public function computerPlay(PlayerAbstract $player, BoardAbstract $board, Slot $slot, GameActions $actions):void;
    public function isWin(BoardAbstract $board, SlotsIteratorAbstract $slots):bool;
    public function isLoose(BoardAbstract $board, SlotsIteratorAbstract $slots):bool;
}