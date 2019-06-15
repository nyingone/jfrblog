<?php
class Router
{
    private $_controller;
    private $_routes = [];
    private $_url;
    private $_namedRoutes = [];

    public function __construct($url)
    {
       $this->_url = $url; 
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

    /*
    public function routeReq()
    {
        $url = '';
        if(isset($_GET['url']))
        {
            $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

            $controller = ucfirst(strtolower($url[0]));
            $controllerClass = "Controller" . $controller;
            $controllerFile = "controllers/" .controlleurClass. '.php';

            if(file_exists($controllerFile))
            {
                require_once($controllerFile);
                $this->controller = new $controllerClass($url);
            }else{
                throw new \Exception('page introuvable'); 
            }
        } else{
            require_once('controllers/ControllerAccueil.php');
            $this->controller = new ControlleurAccueil($url);
        }
        
    
    } */
}