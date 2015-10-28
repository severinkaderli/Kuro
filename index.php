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

    public function delete($id) {
        return 'delete';
    }
}

//TODO: Put these error and exception handlers somewhere
function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // Dieser Fehlercode ist nicht in error_reporting enthalten
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

function exception_handler(\Exception $exception)
{
    echo "<pre>";
    echo "<b>Fatal error:</b> Uncaught exception '" . get_class($exception) . "' with message:<br>";
    echo $exception->getMessage() . "<br>";
    echo "thrown in <b>" . $exception->getFile() . "</b> on Line <b>" . $exception->getLine() . "</b>";
    echo "</pre>";
}

set_exception_handler("exception_handler");

//TODO: Autoloading stuff...
require_once("Kuro/Routing/Router.php");
require_once("Kuro/Routing/Exception/MethodNotAllowedException.php");
require_once("Kuro/Routing/Exception/IllegalCallbackException.php");

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

//Not working callbakcs for error checking
$router->route("GET", "/test", "TestController");
$router->route("GET", "/test1", "NoTestController@test");

//Routing using extra paramter
$router->route("GET", "/controller/{id}", "TestController@show");
$router->route("GET", "/controller/{id}/delete", "TestController@delete");

$router->match();



