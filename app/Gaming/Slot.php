<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming
* @method void __construct(Int $position_x, Int $position_y)
* @method Int __get(String $name)
* @property Int $position_x
* @property Int $position_y
*/

namespace App\Gaming;

use \Exception;

class Slot
{
	private $position_x;
	private $position_y;

	public function __construct(Int $position_x, Int $position_y)
	{
		if ($position_x > 2 || $position_y < 0) {
			throw new Exception("Number must be between 0 and 2");
			return;
		}
		$this->position_x = $position_x;
		$this->position_y = $position_y;
	}
	public function __get(String $name):Int
	{
		if ($name !== "position_x" && $name !== 'position_y') {
			throw new Exception("Can't get any variable except [ position_x, position_y ]");
			return false;
		}
		return $this->{$name};
	}
}