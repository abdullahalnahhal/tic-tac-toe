<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
	private $url = "/api/play";
	private $token = 'test';
    public function testWithoutAhut()
    {
        $response = $this->json('POST', $this->url, ['position_x'=>0, 'position_y'=>1]);
        $response->assertStatus(401)
        	->assertExactJson([
        		'message' => 'Not a valid API request.'
        	]);
    }
    public function testWithwrongAhut()
    {
        $response = $this->withHeaders([
        	'Authorization'=>'Bearer not_existed'
        ])->json('POST', $this->url, ['position_x'=>0, 'position_y'=>1]);
        $response->assertStatus(401)
        	->assertExactJson([
        		'message' => 'There No Player Like These.'
        	]);
    }
    public function testWithNewSlot()
    {
        $response = $this->withHeaders([
        	'Authorization'=>'Bearer not_existed'
        ])->json('POST', $this->url, ['position_x'=>0, 'position_y'=>1]);
        $response->assertStatus(401)
        	->assertExactJson([
        		'message' => 'There No Player Like These.'
        	]);
    }
}
