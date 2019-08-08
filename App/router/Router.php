<?php
class Router
{
    private $_controller;
    private $_routes = [];
    private $_url;
    private $_namedRoutes = [];

    public function __construct($url)
    {
       $this->_url = trim($url,'/'); 
    }

    public function get($path, $callable, $name = null)
    {
        return $this->addRoute('GET', $path, $callable, $name);
    }

    public function post($path, $callable, $name = null)
    {
        return $this->addRoute('POST', $path, $callable, $name);
    }

    private function addRoute($method, $path, $callable, $name)
    {
        $route = new Route($path, $callable);
        $this->_routes[$method][] = $route;
        if($name)
        {
            $this->_namedRoutes[$name] = $route;
        }
        
    }

    public function run()
    {
        if(!isset($this->_routes[ $_SERVER['REQUEST_METHOD']]))
        {
        throw new RouterException('Request Method not found'); 
        }
        // var_dump($this->_routes);
        
        $routeFound = false;
        foreach ($this->_routes[$_SERVER['REQUEST_METHOD']] as $route)
        {
            if($route->match($this->_url))
            {
                $routeFound = true;
                
                $_SERVER['REDIRECT_URL'] = $this->_url;
                $previous = explode('/', $this->_url);
                $_SESSION['previous'] = $previous[0];

                $route->call();
                
            }
        }
        if(!$routeFound)
        {
            throw new RouterException('No matching route found for url: ' . $this->_url); 
        }
 
    }
    public function url($name, $params= [])
    {
        if(!isset(namedRoutes[$name]))
        {
            throw new RouterException('no route matching this name');
        }
    }

    
}