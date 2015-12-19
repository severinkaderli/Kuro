<?php
define("__ROOT__", __DIR__ . "/");
define("BASE_DIR", "http://" . dirname($_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']));

function classAutoload($class) {
    $class = implode("/", explode("\\", $class));
    require_once(__ROOT__ . $class . ".php");
}
spl_autoload_register("classAutoload");
//TODO: Put these error and exception handlers somewhere
function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        
        // Dieser Fehlercode ist nicht in error_reporting enthalten
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

function exception_handler($exception) {
    echo "<pre>";
    echo "<b>Fatal error:</b> Uncaught exception '" . get_class($exception) . "' with message:<br>";
    echo $exception->getMessage() . "<br>";
    echo "thrown in <b>" . $exception->getFile() . "</b> on Line <b>" . $exception->getLine() . "</b>";
    echo "</pre>";
}

set_exception_handler("exception_handler");



use Kuro\Core\Routing\Router;

$router = new Router();

$router->setBasePath(str_replace("http://" . $_SERVER['SERVER_NAME'], "", BASE_DIR));


//Routing using closure
$router->addRoute("GET", "/", function() {
    return "Index-page";
});

$router->addRoute("GET", "/test", function() {
    return "test-page";
});


$response = $router->dispatch();

$response->send();