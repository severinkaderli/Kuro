<?php

class TestController
{
    public function show($id)
    {
        return "show with id -> " . $id;
        //return new View('test.show');
    }

    public function edit()
    {
        return "edit";
    }

    public function index() {
        return "index";
    }
}

//TODO: Refactor this somehow...
function exception_handler(\Exception $exception)
{
    echo "<pre>";
    echo "<b>Fatal error:</b> Uncaught exception '" . get_class($exception) . "' with message:<br>";
    echo $exception->getMessage() . "<br>";
    echo "thrown in <b>" . $exception->getFile() . "</b> on LIne <b>" . $exception->getLine() . "</b>";
    echo "</pre>";
}

set_exception_handler("exception_handler");

require_once("Kuro/Routing/Router.php");
require_once("Kuro/Routing/Exception/MethodNotAllowedException.php");

use Kuro\Routing\Router;

$router = new Router();
$router->setBasePath("/Kuro");

//Routing using closure
$router->route("GET", "/", function () {
    return "HELLO WORLD!<br>The Router works :)";
});

//Routing using Controller and method
$router->route("GET", "/controller", "TestController@index");
$router->route("GET", "/controller/edit", "TestController@edit");

//Routing using extra paramter
$router->route("GET", "/controller/{id}", "TestController@show");

$router->match();



