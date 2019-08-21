<?php
class Controller 
{
 
  protected $view;
  protected $model;
  
  protected $_tab;
  protected $_controllerId;
  protected $_managerId;
  protected $_entity;
  protected $_validate ;
  
  
  public function __construct()
  { 
    $this->_controllerId = ucfirst($this->_tab . 'Controller');
    $this->createModel($this->_tab, '');
    $this->_managerId = ucfirst($this->_tab . 'Manager');
    $this->_entity = ucfirst($this->_tab);
    $this->_validate = new Validate(); 
  }
 
  /**
   * Define view for each action
   */
  public function createView($viewName,$refVue=null)
  {
      $this->view = new View($viewName); 
      $this->view->managerId = $this->managerId;
      $this->view->controllerId = $this->controllerId;

      if(Session::exists('logged_in')) :
        $this->view->_optLogin = "logout";
      else:
        $this->view->_optLogin = "login";
      endif;
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
  
  /**
 * Appel au contrôle géré au niveau entité pour maj/add Book 
 */
  public function isValid()
  {
     $this->result = $this->_validate->check($_POST, $this->_tab, 
     $this->_entity::validation() ); 
      return     $this->result;
  }

  /** */
  public function maj($redir=null)
  {   
    $result = $this->isValid();
    $ok = $result[0];
    if($ok)
    {
      if (isset($result[1]) && !empty($result[1]))
      {
        $class = $result[1];
        $this->model->majTab($class);
        if(Session::exists('nextPath')):
          header("Location: ". Session::get('nextPath'));  
        else:
          if ($redir !== false):
              header("Location: ". Session::get('redirect'));      
          else: 
            //  redirect géré par controleur specif. );
         endif;
        endif;
      }
    }else {     
      
        Session::put('errors', $this->_validate->errors());
        if ($redir === true)
        {
        $this->createview($this->_tab . DS . 'edit', $datas);  
        }
        header("Location: ". Session::get('redirect') );
    }
  }
}