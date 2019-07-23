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
    $this->_controllerId = ucfirst($this->_tab . 'Controller');
    $this->createModel($this->_tab, '');
    $this->_managerId = ucfirst($this->_tab . 'Manager');
    $this->validate = new Validate();
  }
 
  /**
   * Define view for each action
   */
  public function createView($viewName,$datas=[],$infos=[])
  {
      $this->view = new View($viewName, $datas, $infos); 
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
    
  public function isValid($opt = null)
  {
    $this->result = $this->validate->check($_POST, $this->_tab, 
     $this->_entity::ctlMaj() ); 
      return     $this->result;
  }

  public function maj()
  {
    
    $result = $this->isValid();
    $ok = $result[0];
    if($ok)
    {
            if (isset($result[1]) && !empty($result[1]))
      {
        $class = $result[1];
        $this->model->majTab($class);
        $this->createView($this->_tab );
        $this->view->redirect($this->_tab);
      }
      
    }else {     
        $_SESSION['errors'] = $this->validate->errors();
        $this->createview($this->_tab . DS . 'edit', $datas);
        $this->view->redirect($_SESSION['redirect']);
      // } 
    }
  }
}