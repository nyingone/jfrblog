<?php
class Application
{
    protected $controller   = 'HomeController';
    protected $action       = 'index';
    protected $params       = [];

    public function __construct()
    {
       // var_dump( $_SERVER);
        $this->prepareUrl();
        echo $this ->controller, '</br>' , $this->action, '</br>', print_r($this->params);
        if(!(file_exists(CONTROLLER . $this->controller . '.php')))
        { 
            $controller = 'HomeController';
        } 

        if(file_exists(CONTROLLER . $this->controller . '.php'))
        {
            $this->controller = new $this->controller;
            if (method_exists($this->controller,$this->action))
            {
                call_user_func_array([$this->controller,$this->action], $this->params);
            }else   { echo $this->action . 'inaccess';
                    } 
        }else   { echo $this->controller . '.php' . ' access anomaly ';
        }
    }

    /**
     * create a functionn to parse the URI
     */

    protected function prepareUrl()
    {
        $request = trim($_SERVER['REQUEST_URI'],'/');
        
        if (!empty($request))
        {
            $url = explode('/',$request);
           // echo var_dump($url);
            /**
             * Nettoyage url faussée par appel itératifs ex home home home book
             */
            $tst = $url;
            if(isset($tst[1]))
            {
                $u = 2;
                while (isset($tst[$u]) && $tst[$u] == $tst[1])
                {
                    // echo var_dump($tst);
                    // echo 'poste ',  $u . 'contient ' , $tst[$u];
                    unset($tst[$u]);         
                    $u++;
                    // echo '</br>' , $u, $tst[$u];
                }
                $url = array_values($tst);
            }
            // echo var_dump($url);
           /**
            *    var_dump($url);
            *   0 => string 'jfrblog' (length=7)
            *   1 => string 'public' (length=6)
            *   2 => string 'index' (length=5)
            */ 
           $this->controller = isset($url[1]) ? ucfirst($url[1]) . 'Controller' :  'HomeController';
           echo $this->controller, '</br>' , 'is selected' , '</br>' ;
           $this->action     = isset($url[2]) ? $url[2] : 'index';
           if(!(method_exists($this->controller, $this->action)))
           {
               $this->action = 'index';
            }
            unset($url[0], $url[1], $url[2]);  // on conserve les variables si existent
            $this->params = !empty($url) ? array_values($url) : [];
        }
    }
}
