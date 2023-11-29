<?php

namespace App\Messages;

use App\Messages\Http\Response;
use App\Messages\Traits\Router;
use Exception;

class App
{
    use Router;

    /**
     * Run application
     *
     * @return void
     */
    public function run() : void
    {
        $route = $this->getRoute(
            request()->getMethod(),
            request()->getUri()
        );
        
        if (!$route) {
            $route = [
                'callback' => function () {
                    return "Not Founded - 404";
                }
            ];
        }

        $this->execute($route);
    }

    /**
     * Get a specific route by method and uri
     *
     * @param string $method
     * @param string $uri
     * @return array
     */
    protected function getRoute(string $method, string $uri) : array
    {
        foreach ($this->routes($method) as $route) {
            if ($this->match($route, $uri)) {
                return $route;
            }
        }
        return [];
    }

    /**
     * Check if route pattern match with current uri
     *
     * @param array $route
     * @param string $uri
     * @return boolean
     */
    protected function match(array $route, string $uri) : bool
    {
        return (bool) preg_match($route['pattern'], $uri);
    }

    /**
     * Execute route
     *
     * @param array $route
     * @return void
     */
    protected function execute(array $route) : void
    {
        if (is_callable($route['callback'])) {
            echo call_user_func_array($route['callback'], []);
            return ;
        }

        $response = new Response();
        
        if (is_array($route['callback'])) {
            $controller = $route['callback'][0];
            $action = $route['callback'][1];

            if (!class_exists($controller)) {
                throw new Exception("Class $controller not exists");
            }

            $instance = new $controller;
            if (!method_exists($instance, $action)) {
                throw new Exception("Method: $action not exists in $controller");
            }

            $response = call_user_func_array([$instance, $action], []);
        }

        $response->send();
    }
}