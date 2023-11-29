<?php

namespace App\Messages;

use App\Messages\Traits\Router;

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
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $uri = $_SERVER['REQUEST_URI'];
        $route = $this->getRoute($method, $uri);
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
        echo call_user_func_array($route['callback'], []);
    }
}