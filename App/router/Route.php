<?php
class Route
{
    private $_path; 
    private $_callable;
    private $_matches = [];
    private $_params = [];
    protected $controller   ;
    protected $action      ;
    protected $parms       = [];

    public function __construct($path, $callable)
    {
        $this->_path = $path;
        $this->_callable = $callable;
        
    }

    public function match($url)
    {
        // $url = trim($url,'/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'],$this->_path);
        $regex = "#^$path$#i"; // case sensitive i
        if(!preg_match($regex, $url, $matches))
        {
            return false;
        }
        array_shift($matches); // on veut chasser le premier poste du tableau
        $this->_matches = $matches;
        return true;    
    }

    private function paramMatch($match)
    {
        if(isset($this->_params[$match[1]]))
        {
            return '(' . $this->_params[$match[1]] . ')';
        }
        return '([^/]+)';
    }
    public function call()
    {
        if(is_string($this->_callable))
        {
            $request = explode('#',$this->_callable);
            $this->controller = ucfirst(strtolower($request[0])) . 'Controller';
            $action = $request[1];
            $parms = '';
            $opt = '';
            var_dump($this->_matches);
            if(!empty($this->_matches))
            {
                $parm = $this->_matches[0];
                $this->_params = explode('-',$parm);
                if(isset($this->_params[1]))
                {
                    $parms  = $this->_params[1];
                }
                if(isset($this->_params[2]))
                {
                    $opt  = $this->_params[2];
                }
            }
            $controller = new $this->controller;
            return $controller->$action($parms,$opt);

        }else{
            call_user_func_array($this->_callable, $this->_matches);
        }
        
    }

    public function with($params, $regex)
    {
        $regex = str_replace('(','(?:', $regex); // ne capture pas les parenthèses dans l'url.
        $this->_params[$params] = $regex;
        return $this;
    }
}