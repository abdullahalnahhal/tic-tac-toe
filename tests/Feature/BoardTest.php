<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Players;
use App\Gaming\Slot;
use App\Gaming\Board;
use App\Gaming\SlotsIterator;
use App\Gaming\Abstracts\SlotsIteratorAbstract;

class BoardTest extends TestCase
{

	public function players()
	{
		return new Players;
	}
	public function slotsIteratorWithPosYWrong()
	{
		$iterator = new SlotsIterator;
		$iterator->slot = new Slot(0,1);
		$iterator->slot = new Slot(1,2);
		$iterator->slot = new Slot(2,1);
		return $iterator;
	}
	public function slotsIteratorWithPosYSame()
	{
		$iterator = new SlotsIterator;
		$iterator->slot = new Slot(0,1);
		$iterator->slot = new Slot(1,1);
		$iterator->slot = new Slot(2,1);
		return $iterator;
	}
	public function slotsIteratorWithPosXWrong()
	{
		$iterator = new SlotsIterator;
		$iterator->slot = new Slot(0,1);
		$iterator->slot = new Slot(1,2);
		$iterator->slot = new Slot(2,1);
		return $iterator;
	}
	public function slotsIteratorWithLDiag()
	{
		$iterator = new SlotsIterator;
		$iterator->slot = new Slot(0,0);
		$iterator->slot = new Slot(1,1);
		$iterator->slot = new Slot(2,2);
		return $iterator;
	}
	public function slotsIteratorWithRDiag()
	{
		$iterator = new SlotsIterator;
		$iterator->slot = new Slot(0,2);
		$iterator->slot = new Slot(1,1);
		$iterator->slot = new Slot(2,0);
		return $iterator;
	}
	public function slotsIteratorWithPosXSame()
	{
		$iterator = new SlotsIterator;
		$iterator->slot = new Slot(0,1);
		$iterator->slot = new Slot(0,1);
		$iterator->slot = new Slot(0,1);
		return $iterator;
	}
    public function testIsRowFalse()
    {
    	$iterator = $this->slotsIteratorWithPosYWrong();
    	$players = Players::find(1);
    	$board = new Board($players);
    	$is_row = $board->isRow($iterator);
    	$this->assertFalse($is_row);
    }
    public function testIsRowTrue()
    {
    	$iterator = $this->slotsIteratorWithPosYSame();
    	$players = Players::find(1);
    	$board = new Board($players);
    	$is_row = $board->isRow($iterator);
    	$this->assertTrue($is_row);
    }
    public function testIsColumnFalse()
    {
    	$iterator = $this->slotsIteratorWithPosXWrong();
    	$players = Players::find(1);
    	$board = new Board($players);
    	$is_column = $board->isColumn($iterator);
    	$this->assertFalse($is_column);
    }
    public function testIsColumnTrue()
    {
    	$iterator = $this->slotsIteratorWithPosXSame();
    	$players = Players::find(1);
    	$board = new Board($players);
    	$is_column = $board->isColumn($iterator);
    	$this->assertTrue($is_column);
    }
    public function testIsLDiag()
    {
    	$iterator = $this->slotsIteratorWithLDiag();
    	$players = Players::find(1);
    	$board = new Board($players);
    	$diag = $board->isLDiag($iterator);
    	$this->assertTrue($diag);
    }
    public function testIsRDiag()
    {
    	$iterator = $this->slotsIteratorWithRDiag();
    	$players = Players::find(1);
    	$board = new Board($players);
    	$diag = $board->isRDiag($iterator);
    	$this->assertTrue($diag);
    }
    // public function testIsLDiagWrong()
    // {
    // 	$iterator = $this->slotsIteratorWithPosXWrong();
    // 	$players = Players::find(1);
    // 	$board = new Board($players);
    // 	$diag = $board->isLDiag($iterator);
    // 	$this->assertFalse($diag);
    // }
    // public function testIsRDiagWrong()
    // {
    // 	$iterator = $this->slotsIteratorWithPosXWrong();
    // 	$players = Players::find(1);
    // 	$board = new Board($players);
    // 	$diag = $board->isRDiag($iterator);
    // 	$this->assertFalse($diag);
    // }
}
