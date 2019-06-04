<?php
class Controller 
{
    protected $view;
    protected $model;

   
    /**
     * Define view for each action
     */
    public function createView($viewName,$datas=[])
    {
        $this->view = new View($viewName, $datas); 
        return $this->view;
    }

    public function createModel($modelName,$datas=[])
    {
        $modelName = ucfirst($modelName) . 'Manager';
        if(file_exists(MANAGER . $modelName . '.php'))
        {
            
            $this->model = new $modelName($modelName, $datas);
        }else {
            echo MANAGER . $modelName . '.php' . ' non trouvé';   }
    }
    
}