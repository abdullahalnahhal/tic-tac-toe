<?php

/**
* @author Abdullah Al-Nahhal abduulahalnahhal@gmail.com
* @package App\Gaming
* @method void __set(String $name , Slot $value)
* @method Int count()
* @method Slot rand(Int $number=1)
* @method void unset(Int $number)
* @method Array source()
*/

namespace App\Gaming;

use App\Gaming\Slot;
use App\Gaming\Abstracts\SlotsIteratorAbstract;
use \Exception;
use \Iterator;

class SlotsIterator implements Iterator, SlotsIteratorAbstract
{
    private $position = 0;
    private $array = [];
    
    public function __construct() 
    {
        $this->position = 0;
    }

    public function rewind() 
    {
        $this->position = 0;
    }

    public function current() 
    {
        return $this->array[$this->position];
    }

    public function key() 
    {
        return $this->position;
    }

    public function next() 
    {
        ++$this->position;
    }

    public function valid() 
    {
        return isset($this->array[$this->position]);
    }

    public function __set(String $name , Slot $value):void
    {
    	if ($name !== "slot") {
    		throw new Exception("You can't set any parameter except 'slot' ");
    		return;
    	}
    	$this->array[] = $value;
    }

    public function count():Int
    {
        return count($this->array);
    }

    public function rand(Int $number=1):Slot
    {
        $rand = array_rand($this->array);
        return $this->array[$rand];
    }
    public function unset(Int $number):void
    {  
        unset($this->array[$number]);
    }
    public function source():Array
    {  
        return $this->array;
    }
}