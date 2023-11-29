<?php

namespace App\Messages\Traits;

trait Router
{
    public $routes = [];

    /**
     * Add new route to application type GET
     *
     * @param string $path
     * @param [type] $callback
     * @return void
     */
    public function get(string $path, $callback)
    {
        $this->add(__FUNCTION__, $path, $callback);
    }

    /**
     * Add new route to application type GET
     *
     * @param string $path
     * @param [type] $callback
     * @return void
     */
    public function post(string $path, $callback)
    {
        $this->add(__FUNCTION__, $path, $callback);
    }

    /**
     * Add new route to application
     *
     * @param string $method
     * @param string $path
     * @param [type] $callback
     * @return void
     */
    protected function add(string $method, string $path, $callback)
    {
        $this->routes[$method][] = [
            'path' => $path,
            'callback' => $callback,
            'pattern' => $this->generatePattern($path)
        ];
    }

    /**
     * Generate string pattern to math eith uri
     *
     * @param string $path
     * @return void
     */
    protected function generatePattern(string $path)
    {
        $path = str_replace("/", '\/', $path);
        return "/^$path$/";
    }

    /**
     * Return a array with routes
     *
     * @param string $method
     * @return array
     */
    public function routes(string $method) : array
    {
        return $this->routes[$method] ?? [];
    }
}