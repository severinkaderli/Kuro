<?php
//Root path to the kuro directory -> /var/www/html/kuro
define("__ROOT__", __DIR__ . "/");

//Either http:// or https://
define("PROTOCOL", (isset($_SERVER["https"]) ? "https://" : "http://"));

//Url to the directory of kuro -> http://example.com/path/to/kuro
define("BASE_URL", PROTOCOL . dirname($_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']));

//Url of the server -> http://example.com
define("SERVER_URL", PROTOCOL . $_SERVER['SERVER_NAME']);

//Only the path of Kuro -> /path/to/kuro
define("BASE_PATH", str_replace(SERVER_URL, "", BASE_URL));

function constDebug($name)
{
    echo $name . ": " . constant($name) . "<br>";
}

constDebug("BASE_PATH");



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
var_dump(PROTOCOL);
$router = new Router();


//Routing using closure
$router->addRoute("GET", "/", function() {
    return "Index-page";
});

$router->addRoute("GET", "/test", function() {
    return "test-page";
});


$response = $router->dispatch(new Kuro\Core\Http\Request($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]));

$response->send();