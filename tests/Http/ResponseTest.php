<?php

use Kuro\Http\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

	public function testDefaultResponse()
    {
        $response = new Response();

        $this->assertEquals("", $response->getBody());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
    }

    public function testSettingProperties()
    {
    	$response = new Response();

    	$response->setBody("Hello World!");
    	$response->setStatusCode(404);
    	$response->setHeader("X-Test", "test-value");

    	$this->assertEquals("Hello World!", $response->getBody());
    	$this->assertEquals(404, $response->getStatusCode());
    	$this->assertEquals(["X-Test" => "test-value"], $response->getHeaders());
    }
}