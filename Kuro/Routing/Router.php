<?php

namespace Kuro\Routing;

use Closure;
use Kuro\Routing\Exception\MethodNotAllowedException;

class Router
{
    /**
     * @var array Array which holds all defined routes.
     */
    private $routes = [];

    /**
     * @var string The Base path which is used for routing.
     */
    private $basePath;

    /**
     * @var array Array of allowed methods.
     */
    private $allowedMethods = ["POST", "GET", "PUT", "PATCH", "DELETE"];

    /**
     * Returns all defined routes.
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Set the base path for routing.
     *
     * @param $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Adds a new route
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
     * Checks if the current Request is registered as route and if so call
     * the callback function of the route;
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

            //Simple matching for now
            if ($route["route"] === $requestUrl) {
                $matchRoute = true;
            }

            if ($matchMethod && $matchRoute) {

                //Check if the callback is a Closure
                if ($route["callback"] instanceof Closure) {
                    echo $route["callback"]();
                    break;
                }

                //If it's a string try to call the controller
                if(is_string($route["callback"])) {

                    $controllerInformation = explode("@", $route["callback"]);

                    //Trying to instantiate the controller
                    $controller = new $controllerInformation[0];

                    //Try to call the controller method
                    echo $controller ->$controllerInformation[1]();

                    break;
                }

                //Nothing callable
            }

            //Not a valid route
        }
    }
}