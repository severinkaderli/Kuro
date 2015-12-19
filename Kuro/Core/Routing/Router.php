<?php
namespace Kuro\Core\Routing;

use Closure;

/**
 * This router handles the main request routing for the framework. You can add
 * new routes which the router tries to match on a request and tries to call
 * the given function/method.
 *
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
     * These are the allowed methods for routes.
     * @var array
     */
    private $allowedMethods = ["POST", "GET", "PUT", "PATCH", "DELETE"];
    
    /**
     * @return array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }
    
    /**
     * Define a new route.
     *
     * @param string $methods
     * @param string $route
     * @param callable $callback
     *
     */
    public function addRoute(string $methods, string $route, callable $callback)
    {
        $methods = explode("|", $methods);
        
        foreach ($methods as $method) {
            if (!in_array(strtoupper($method), $this->allowedMethods)) {
                
                //throw new MethodNotAllowedException($method);
                
            }
        }
        $this->routes[] = ["methods" => $methods, "route" => $route, "callback" => $callback];
    }
    
    /**
     * Define multiple routes using an array. The array should look
     * like this:
     *
     * @param array $routes
     */
    public function addRoutes(array $routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($route[0], $route[1], $route[2]);
        }
    }
    
    /**
     * We try to find a matching route for the given request. If we find one
     * we return a response object with the correct response body. In case if
     * there's no matching route we return a 404 response.
     *
     * @return \Kuro\Core\Http\Response
     */
    public function dispatch(\Kuro\Core\Http\Request $request) : \Kuro\Core\Http\Response
    {
        $response = new \Kuro\Core\Http\Response();

        //Try to find a matching route
        foreach ($this->getRoutes() as $route) {
            
            //Check if there are any matching methods
            $matchMethod = false;
            foreach ($route["methods"] as $method) {
                if (strcasecmp($method, $request->getMethod()) === 0) {
                    $matchMethod = true;
                    break;
                }
            }
            
            if (!$matchMethod) {
                continue;
            }
            
            //Check if the a route matches the current route
            //TODO: Add posibility of multiple parameter wildcardds
            $matchRoute = false;
            $routePattern = preg_replace("/{[A-Za-z0-9]+}/", "(?P<parameter>[0-9]+)", $route["route"]);
            $routePattern = str_replace("/", '\/', $routePattern);
            $routePattern = "/^" . $routePattern . "$/";
            
            //Check the route and get extra parameter if available
            $routeParameter = [];
            if (preg_match($routePattern, $request->getUrl(), $routeParameter) === 1) {
                $matchRoute = true;
            }
            
            //Try to call the callback function
            if ($matchMethod && $matchRoute) {
                $returnArray = [];
                $returnArray["parameter"] = isset($routeParameter["parameter"]) ? $routeParameter["parameter"] : null;
                
                if ($route["callback"] instanceof Closure) {
                    
                    $returnArray["type"] = "Closure";
                    $returnArray["function"] = $route["callback"];
                    $response->setStatusCode(200);
                    $response->setBody($route["callback"]());
                    return $response;
                }
                
                //If the callback is a string try to call the right method
                if (is_string($route["callback"])) {
                    
                    $returnArray["type"] = "Controller";
                    
                    $controllerCallback = explode("@", $route["callback"]);
                    if (count($controllerCallback) !== 2) {
                        return ["type" => "error"];
                    }
                    
                    //Get controller name and method from callback string
                    $controllerName = "Core\\Controller\\" . $controllerCallback[0];
                    $controllerMethod = $controllerCallback[1];
                    
                    //Check if the controller exists
                    if (!class_exists($controllerName)) {
                        return ["type" => "error"];
                    }
                    
                    //Check if the method exists
                    if (!method_exists($controllerName, $controllerMethod)) {
                        return ["type" => "error"];
                    }

                    $response->setStatusCode(200);
                    $response->setBody((new $controllerName)->$controllerMethod());
                    
                    return $response;
                }
            }
        }

        $response->setStatusCode(404);
        $response->setBody("<h1>404 - Not found</h1>");
        return $response;
    }
}