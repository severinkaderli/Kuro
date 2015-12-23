<?php

use Kuro\Routing\Router;

class RouterTest extends PHPUnit_Framework_TestCase
{

	private $router;

	public function setUp()
	{
		$this->router = new Router();
	}

	public function testDefaultRouter()
	{
		$this->assertEquals([], $this->router->getRoutes());
	}

	public function testAddingAndGettingSimpleRoutesWithClosure()
	{
		$this->router->addRoute("GET", "/", function() {return "hello";});
		$this->router->addRoutes([["POST", "/test", function() {return "test";}], ["PATCH", "/hello", function() {return "test";}]]);

		$this->assertEquals(["GET"], $this->router->getRoutes()[0]["methods"]);
		$this->assertEquals("/test", $this->router->getRoutes()[1]["route"]);
		$this->assertInstanceOf("Closure", $this->router->getRoutes()[2]["callback"]);
	}

	public function testAddingRouteWithMultipleMethods()
	{
		$this->router->addRoute("PUT|PATCH", "/method", function() {return "method";});

		$this->assertEquals(["PUT", "PATCH"], $this->router->getRoutes()[0]["methods"]);
		$this->assertEquals("/method", $this->router->getRoutes()[0]["route"]);
		$this->assertInstanceOf("Closure", $this->router->getRoutes()[0]["callback"]);
	}

	public function testRoutesWithNotAllowedException()
	{
		$this->setExpectedException('Kuro\Routing\Exception\MethodNotAllowedException');
		$this->router->addRoute("SLEEP", "/nope", function(){return "nope";});
	}


	public function tearDown()
	{
		$this->router = null;
	}
}