<?php
class BookController extends Controller
{
  public $data = [];
  private $_tab = 'book';
  private $_entity = 'Book';
  private $_controller ;
  private $_manager ;
  private $_controllerId ;
  private $_managerId ;
  protected $level='N0' ;

  
  public function __construct()
  {
  $this->_controllerId = ucfirst($this->_tab . 'Controller');
  $this->createModel($this->_tab, '');
  $this->_managerId = ucfirst($this->_tab . 'Manager');
  $this->validate = new Validate();
  }


  /**
   * Visiteurs/Gestion vue liste Book 
   */
  public function list()
  {

    $this->createModel($this->_tab, '');
    $datas = $this->model->getBooks(null, $this->level);
    $this->createView($this->_tab . DS . 'list', $datas);
    $this->view->render();
  
  }
  /**
   * Visiteurs/Gestion vue un Book avec liste des épisodes 
   */
  public function show($id)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getBooks($id, $this->level);
    $this->createview($this->_tab . DS . 'show', $datas);
    $this->view->render();
  }

/** Administrateur/ *********************************************************
 * 
   * Gestion vue Index Book 
   * 
   */
  public function index()
  {
     $this->createModel($this->_tab, '');
    $datas = $this->model->getBooks(null,$this->level);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->render();
  }
/**
 * vue Edit pour maj/add Book 
 */
  public function edit($id = null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    ($id) ? $datas = $this->model->getBooks($id,$this->level) : $datas[] = new Book();
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->render($datas);
  }
/**
 * validation saisie Edit pour maj/add Book gérée via Core/ctl
 */
public function isValid($opt=null)
  {
    $this->result = $this->validate->check($_POST, $this->_tab, 
     $this->_entity::validation() ); 
    return     $this->result;
  }
}
  