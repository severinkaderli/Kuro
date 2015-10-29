<?php

namespace Kuro\Routing;

use Closure;
use Kuro\Exception\ClassNotFoundException;
use Kuro\Exception\MethodNotFoundException;
use Kuro\Routing\Exception\IllegalCallbackException;
use Kuro\Routing\Exception\MethodNotAllowedException;


/**
 * Kuro\Routing\Router
 *
 * This class handles all routings for the framework. Each route has a
 * method and a function, which is getting called when the route is invoked.
 *
 * @package Kuro\Routing
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class Router
{
    /**
     * This array holds all defined routes in the application.
     * @var array
     */
    private $routes = [];

    /**
     * The base path which is used as base for all routes.
     * @var string
     */
    private $basePath;

    /**
     * These are the allowed methods for routes.
     * @var array
     */
    private $allowedMethods = ["POST", "GET", "PUT", "PATCH", "DELETE"];

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Define a new route.
     *
     * @param string $methods
     * @param string $route
     * @param mixed $callback
     *
     * @throws MethodNotAllowedException
     */
    public function route($methods, $route, $callback)
    {
        $methods = explode("|", $methods);

        foreach ($methods as $method) {
            if (!in_array(strtoupper($method), $this->allowedMethods)) {
                throw new MethodNotAllowedException($method . " is not an allowed method!");
            }
        }
        $this->routes[] = ["methods" => $methods, "route" => $route, "callback" => $callback];
    }

    /**
     * @throws ClassNotFoundException
     * @throws IllegalCallbackException
     */
    public function match()
    {
        $requestUrl = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        //Strip base path and query string from request url
        $requestUrl = substr($requestUrl, strlen($this->basePath));
        if ($strpos = strpos($requestUrl, "?") !== false) {
            $requestUrl = substr($requestUrl, 0, $strpos);
        }

        $anyRoute = false;

        foreach ($this->getRoutes() as $route) {

            $matchMethod = false;
            foreach ($route["methods"] as $method) {
                if (strcasecmp($method, $requestMethod) === 0) {
                    $matchMethod = true;
                    break;
                }
            }

            if (!$matchMethod) {
                continue;
            }

            //Check if the route is correct
            $matchRoute = false;

            $routePattern = preg_replace("/{[A-Za-z0-9]+}/", "(?P<parameter>[A-Za-z0-9]+)", $route["route"]);
            $routePattern = str_replace("/", '\/', $routePattern);
            $routePattern = "/^" . $routePattern . "$/";

            $routeParameter = [];
            if (preg_match($routePattern, $requestUrl, $routeParameter) === 1) {
                $matchRoute = true;
            }

            if ($matchMethod && $matchRoute) {

                //Check if the callback is a Closure
                if ($route["callback"] instanceof Closure) {
                    echo $route["callback"]();
                    break;
                }

                //If it's a string try to call the controller
                if (is_string($route["callback"])) {

                    $controllerCallback = explode("@", $route["callback"]);

                    if (count($controllerCallback) !== 2) {
                        throw new IllegalCallbackException("No callback method was specified! Expected format is:
                        Controller@method");
                    }

                    $controllerName = $controllerCallback[0];
                    $controllerMethod = $controllerCallback[1];

                    //Trying to instantiate the controller
                    if (!class_exists($controllerName)) {
                        throw new ClassNotFoundException("Class '" . $controllerName . "' was not found!");
                    }
                    $controller = new $controllerName();

                    //Try to call the controller method
                    if (!method_exists($controller, $controllerMethod)) {
                        throw new MethodNotFoundException("Method '" . $controllerMethod . "' was not found in class '"
                            . $controllerName . "'!");
                    }

                    //TODO: Checking parameter?
                    if (isset($routeParameter["parameter"])) {
                        echo $controller->$controllerMethod($routeParameter["parameter"]);
                    } else {
                        echo $controller->$controllerMethod();
                    }

                    $anyRoute = true;

                    break;
                }
            }
        }

        if(!$anyRoute){
            echo "404 - Not found";
        }
    }
}