<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Gaming\Slot;
use App\Gaming\SlotsIterator;
use App\Gaming\Abstracts\SlotsIteratorAbstract;

class SlotsIteratorTest extends TestCase
{
    public function testSetterWrongName()
    {
    	$iterator = new SlotsIterator;
    	$this->expectException(\Exception::class);
    	$iterator->any = new slot(0, 1);
    }
    public function testSetterWrongValue()
    {
    	$iterator = new SlotsIterator;
    	$this->expectException(\TypeError::class);
    	$iterator->slot = 1;
    }
    public function testSetter()
    {
    	$iterator = new SlotsIterator;
    	$iterator->slot = new slot(0, 1);
    	$this->assertInstanceOf(SlotsIteratorAbstract::class, $iterator);
    }
    public function testCount()
    {
    	$iterator = new SlotsIterator;
    	$iterator->slot = new slot(0, 1);
    	$this->assertEquals(1, $iterator->count());
    }
    public function testRand()
    {
    	$iterator = new SlotsIterator;
    	$iterator->slot = new slot(0, 1);
    	$this->assertInstanceOf(Slot::class, $iterator->rand());
    }
    public function testSource()
    {
    	$iterator = new SlotsIterator;
    	$iterator->slot = new slot(0, 1);
    	$this->assertEquals([new slot(0, 1)], $iterator->source());
    }
    public function testUnset()
    {
    	$iterator = new SlotsIterator;
    	$iterator->slot = new slot(0, 1);
    	$iterator->unset(0);
    	$this->assertEquals(0, $iterator->count());
    }



}
