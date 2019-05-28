<?php
class Routeur
{
    private $controller;
    private $route;

    public function routeReq
    {
        try
        {
            spl_autoload_register(
                    function($class){
                    require_once(MODEL . $class . '.php');
                    });

            $url = '';
            if(isset($_GET['url'])
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
                    throw new exception('page introuvable'); 
                }
                else{
                    require_once('controllers/ControllerAccueil.php');
                    $this->controller = new ControlleurAccueil($url);
                }
            }
        }
        catch(Eception $e)
        {
            $errmsg = $e->getMessage();
            require_once('views/viewError.php');
        }
    }
}