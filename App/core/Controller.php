<?php
class Controller 
{
    protected $view;
    protected $model;

    /**
     * Define view for each action
     */
    public function view($viewName,$datas=[])
    {
        echo '</br>' , 'appel via controller methode  ' . __METHOD__;
        $this->view = new View($viewName, $datas);
        // var_dump($this->view);
       
        return $this->view;
    }

    public function model($modelName,$datas=[])
    {
        echo '</br>' , 'appel via controller methode  ' . __METHOD__;
        $modelName = ucfirst($modelName) . 'Manager';
        if(file_exists(MODEL . $modelName . '.php'))
        {
            echo MODEL . $modelName . '.php' . ' loaded';  
            require MODEL . $modelName . '.php'; // ! autoload
            $this->model = new $modelName($modelName, $datas);

           //  $this->model->inventory($modelName,$datas);
        }else {
            echo MODEL . $modelName . '.php' . ' non trouvé';   }
    }
    
}