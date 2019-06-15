<?php
class UserController extends Controller
{
  public $data = '';
  private $ctl = 'user';

  public function __construct(){
    $this->createModel($this->ctl, '');
  }
 

/** create all the actions we can have */
    public function index(){
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
      $datas = $this->model->login();
      $this->createView($this->ctl . DS . 'login', $datas);
      $this->view->page_title = "Connexion
      
      ";
      $this->view->render();
    }
}