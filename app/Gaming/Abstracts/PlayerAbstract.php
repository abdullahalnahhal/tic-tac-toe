<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming\Abstracts
* @method void __construct(Games $game, SlotsIterator $actions, Int $type = 0)
* @method void makeAction(Slot $slot, GameActions $action)
* @method Games game()
* @method SlotsIterator actions()
* @method Int type()
* @property Games $game
* @property SlotsIterator $actions
* @property Int $type
*/

namespace App\Gaming\Abstracts;

use App\Gaming\Abstracts\SlotsIteratorAbstract;
use App\Players;
use App\Games;
use App\Gaming\Slot;
use App\GameActions;

abstract class PlayerAbstract
{
	protected $game;
	protected $actions;
	protected $type;
    abstract public function __construct(Games $game, SlotsIteratorAbstract $actions, Int $type = 0);
    abstract public function makeAction(Slot $slot, GameActions $action):void;
    public function game():Games
    {
    	return $this->game;
    }
    public function actions():SlotsIterator
    {
        return $this->actions;
    }
    public function type():Int
    {
        return $this->type;
    }
}