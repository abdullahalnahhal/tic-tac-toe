<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Gaming\Slot;

class SlotTest extends TestCase
{

    public function testAddWrongPostion()
    {
    	$this->expectException(\Exception::class);
    	$slot = new Slot(5, 6);
    }
    public function testNormalAddPosition()
    {
		$slot = new Slot(0, 2);
		$this->assertInstanceOf(Slot::class, $slot);
    }
    public function testGetnositionX()
    {
		$slot = new Slot(0, 2);
		$this->assertEquals(0, $slot->position_x);
    }
    public function testGetnositionY()
    {
		$slot = new Slot(0, 2);
		$this->assertEquals(2, $slot->position_y);
    }
    public function testGetException()
    {
    	$slot = new Slot(0, 2);
    	$this->expectException(\Exception::class);
    	$slot->any;
    }

}
