<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming\Abstracts
* @method void __set(String $name , Slot $value)
* @method Int count()
* @method Slot rand(Int $number=1)
* @method void unset(Int $number)
* @method Array source()
* @property Int $position
* @property Array $array
*/

namespace App\Gaming\Abstracts;

use App\Gaming\Slot;

interface SlotsIteratorAbstract 
{
    public function __set(String $name , Slot $value):void;
    public function count():Int;
    public function rand(Int $number=1):Slot;
    public function unset(Int $number):void;
    public function source():Array;
}