<?php
class Controller 
{
    protected $view;
    protected $model;
    protected $managerId;
    protected $controllerId;
    protected $validate ;
    
    public function __construct()
    {
      
    }
 
    /**
     * Define view for each action
     */
    public function createView($viewName,$datas=[])
    {
        $this->view = new View($viewName, $datas); 
        $this->view->managerId = $this->managerId;
        $this->view->controllerId = $this->controllerId;
        return $this->view;
    }

    public function createModel($modelName,$datas=[])
    {
        $this->controllerId = ucfirst($modelName) . 'Controller';
        $modelName = ucfirst($modelName) . 'Manager';

        if(file_exists(MANAGER . $modelName . '.php'))
        {  
            $this->model = new $modelName($modelName, $datas);
            $this->managerId = $modelName;
            
        }else {
            echo MANAGER . $modelName . '.php' . ' non trouvé';   }
    }
    
}