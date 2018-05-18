<?php

namespace Core;

class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * Add route configuration
     * 
     * @param $method
     * @param $path
     * @param $callback
     * @return $this
     */
    public function add($method, $path, $callback)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }
        $uri = substr($path, 0, 1) !== '/' ? '/' . $path : $path;
        $pattern = str_replace('/', '\/', $uri);
        $route = '/^' . $pattern . '$/';
        $this->routes[$method][$route] = $callback;
        return $this;
    }

    /**
     * Run router
     * 
     * @param $method
     * @param $uri
     * @return mixed|null
     */
    public function run($method, $uri)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            return null;
        }
        foreach ($this->routes[$method] as $route => $callback) {
            if (preg_match($route, $uri, $parameters)) {
                array_shift($parameters);
                return [$callback, $parameters];
            }
        }
        return null;
    }
}