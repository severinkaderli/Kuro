<?php

require_once("./vendor/autoload.php");
require_once("./init.php");

var_dump(BASE_PATH);echo "<br>";


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



use Kuro\Routing\Router;
var_dump(PROTOCOL);
$router = new Router();


//Routing using closure
$router->addRoute("GET", "/", function() {
    return "Index-page";
});

$router->addRoute("GET", "/test", function() {
    return "test-page";
});


$response = $router->dispatch(new Kuro\Http\Request($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]));

$response->send();