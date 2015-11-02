<?php


//TODO: Put these error and exception handlers somewhere
function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // Dieser Fehlercode ist nicht in error_reporting enthalten
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

function exception_handler($exception)
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
require_once("Kuro/Exception/ClassNotFoundException.php");
require_once("Kuro/Exception/MethodNotFoundException.php");
require_once("Kuro/Exception/PropertyNotDefinedException.php");
require_once("Kuro/Database/Model.php");

use Kuro\Routing\Router;

$router = new Router();
$router->setBasePath("/Kuro");
$test = $router->getBasePath();

//Routing using closure
$router->addRoute("GET", "/", function () {
    return "HELLO WORLD!<br>The Router works :)<br>";
});

$routeCallback = $router->matchRoute();
$callbackLength = count($routeCallback);
if($callbackLength === 1) {
    echo $routeCallback[0]();
} else if($callbackLength === 3) {

    $controllerName = $routeCallback[0];
    $controllerMethod = $routeCallback[1];
    $controllerParameter = $routeCallback[2];

    $controller = new $controllerName();
    echo $controller->$controllerMethod($controllerParameter);
} else {
    http_response_code(404);
    echo "<h1>404 - Not found</h1>";
    exit();
}


class TestModel extends Kuro\Database\Model {

}

$model = new TestModel();
$model->sefStuff("test");
