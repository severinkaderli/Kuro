<?php

use Kuro\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{

	public function testDefaultRequest()
    {
        $request = new Request("/");

        $this->assertEquals("/", $request->getUrl());
        $this->assertEquals("GET", $request->getMethod());
        $this->assertEquals([], $request->getHeaders());
    }

    public function testSettingProperties()
    {
    	$request = new Request("/");

   		$request->setUrl("/subdir/kuro/test/");
   		$request->setMethod("PATCH");
   		$request->setHeader("test-header", 505);	

   		$this->assertEquals("/test", $request->getUrl());
   		$this->assertEquals("PATCH", $request->getMethod());
   		$this->assertEquals(["test-header" => 505], $request->getHeaders());
    }

    public function testRemoveQueryStringFromUrl()
    {
    	$request = new Request("/test/?query=true", "POST");

    	$this->assertEquals("/test", $request->getUrl());
    	$this->assertEquals("POST", $request->getMethod());
        $this->assertEquals([], $request->getHeaders());
    }
}