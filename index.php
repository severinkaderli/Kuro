<?php
class TestController{
    public function show() {
        return "test";
        //return new View('test.show');
    }
}
//TODO: Refactor this somehow...
function exception_handler(\Exception $exception) {
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
$router -> setBasePath("/Kuro");

//Routing using closure
$router->route("GET", "/", function () {
    return "HELLO WORLD!<br>The Router works :)";
});

//Routing using Controller and method
$router->route("GET", "/controller", "TestController@show");

$router->match();


