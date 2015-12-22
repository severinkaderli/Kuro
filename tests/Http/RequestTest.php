<?php

use Kuro\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase {

	public function testDefaultRequest()
    {
        $request = new Request("/");

        $this->assertEquals("/", $request->getUrl());
        $this->assertEquals("GET", $request->getMethod());
        $this->assertEquals([], $request->getHeaders());
    }
}