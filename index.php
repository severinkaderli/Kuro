<?php

//TODO: Refactor this somehow...
function exception_handler(\Exception $exception) {
    echo "<pre>";
        echo "<b>Fatal error:</b> Uncaught exception '" . get_class($exception) . "' with message:<br>";
        echo $exception->getMessage() . "<br>";
        echo "\tthrown in <b>" . $exception->getFile() . "</b> on LIne <b>" . $exception->getLine() . "</b>";
    echo "</pre>";
}

set_exception_handler("exception_handler");

require_once("Kuro/Routing/Router.php");
require_once("Kuro/Routing/Exception/MethodNotAllowedException.php");

use Kuro\Routing\Router;

$router = new Router();
$router->route("GETs", "/", function () {
    return "HELLO WORLD!<br>The Router works :)";
});

$router->route("POST", "/", function () {

});

$router->match();



