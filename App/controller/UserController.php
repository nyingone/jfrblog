<?php
class UserController extends Controller
{
  public $data = '';
  protected $ctl = 'user';
  protected $_tag = 'home';
  protected $_tab = 'user';
  protected $_entity = 'User';

  /**
     * Constructeur de la classe      * géré via classe Table.
     * @param array $donnees
     * @return void
     */
  

/** create all the actions we can have */
  public function index()
  {
    $datas = $this->model->getUsers();
    $this->createView($this->ctl . DS . 'index', $datas);
    $this->view->page_title = "Abonnés";
    $this->view->render();
    
  }

  public function register()
  {
    $datas = $this->model->register();
    $this->createView($this->ctl . DS . 'register', $datas);
    $this->view->page_title = "Abonnés";
    $this->view->render();
  }

  public function login()
  {
    // $datas = $this->model->login();
    $datas = '';
    $this->createView($this->ctl . DS . 'login', $datas);
    $this->view->page_title = "Connexion";
    $this->view->render();
  }

  public function connect()
  {
    $opt = 'login';
    $result = $this->isValid($opt);
    $ok = $result[0];
    
    if($ok)
    {
     
      // ($result[1]) est objet User;
      if (isset($result[1]) && !empty($result[1]))
      {
        $class = $result[1];
        $logged_in = $this->model->login($class);
        $_SESSION['logged_in'] = $logged_in;
        
        if($logged_in)
        {
          $_SESSION['redirect']= 'book';
        }    
        header("location:" . $_SESSION['redirect']);
      }
     
    }else{     
        $_SESSION['errors'] = $this->validate->errors();
        $this->createview($this->_tab . DS . 'login', $datas); 
        $this->view->redirect($_SESSION['redirect']); 
    } 

  }
  
  public function addUser()
  {
    $opt = 'register';
    $result = $this->isValid($opt);
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
    }else{     
        $_SESSION['errors'] = $this->validate->errors();
        $this->createview($this->_tab . DS . 'register', $datas);
        $this->view->redirect($_SESSION['redirect']);
      }
    }

    public function isValid($opt=null)
  {
    $this->result = $this->validate->check($_POST, $this->_tab, 
    $this->_entity::validation($opt) ); 
    return     $this->result;
  }
}