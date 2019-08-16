<?php
class UserController extends Controller
{
 
  protected $ctl = 'user';
  protected $_tab = 'user';


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
    $this->createView($this->ctl . DS . 'register', null);
    $this->view->page_title = "Pour vous inscrire ...";
    $this->view->render();
  }

  public function login()
  {
    $datas = '';
    $this->createView($this->ctl . DS . 'login', $datas);
    $this->view->page_title = "Connexion";
    $this->view->render();
  }

  public function logout()
  {
    $this->model->logout();
    header("location:" . Session::get('redirect'));
  }

  public function connect()
  {
    
    $opt = 'login';
    $result = $this->isValid($opt); // + objet USR initialisé avec usr et mdp saisi
    
    $ok = $result[0];
    
    if($ok)
    {
      // ($result[1]) est objet User;
      if (isset($result[1]) && !empty($result[1]))
      {
        $visiteur = $result[1];
        $logged_in = $this->model->login($visiteur);
  
        if($this->model->isLoggedIn() == true ):
         
          if(Session::get('groupId') >= '50'):
            Session::put('redirect', 'book');
          else:
            Session::put('redirect', 'book-list/');
          endif;
        endif;
       header("location:" . Session::get('redirect'));
      }
     
    }else{     
        Session::put('errors', $this->validate->errors());
        $this->createview($this->_tab . DS . 'login', $datas); 
        header("location:" . Session::get('redirect'));
    } 

   //  
  }
  
 
}