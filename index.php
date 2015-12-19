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
//Todo: Make it possible to use https...
echo "BASEDIR: " . BASE_DIR; echo "<br>";
echo "SERVERNAME: " . $_SERVER['SERVER_NAME'];echo "<br>";
$router->setBasePath(str_replace("http://" . $_SERVER['SERVER_NAME'], "", BASE_DIR));

echo "BASE_PATH: ".$router->getBasePath(); echo "<br>";

//Routing using closure
$router->addRoute("GET", "/", function() {
    echo "Index-page";
});

$router->addRoute("GET", "/test", function() {
    echo "test-page";
});


$match = $router->dispatch();

echo "<pre>";
var_dump($match);
echo "</pre>";

switch ($match["type"]) {
    case "Closure":
        $match["function"]();
        break;
    case "Controller":
        $controller = new $match["controller"]();
        if (is_null($match["parameter"])) {
            $controller->$match["method"]();
        } else {
            $controller->$match["method"]($match["parameter"]);
        }
        break;
    case "Error":
        //Core\Routing\Redirect::to("/");
        http_response_code(500);
        echo "error";
        break;
}