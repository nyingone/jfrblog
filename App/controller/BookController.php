<?php
class BookController extends Controller
{
 
  protected $_tab = 'book';
  protected $level='N0' ;
  
  /** PasserBy / Visiteurs/ *********************************************************
  * 
  * Gestion vue Book List
  */
  public function list()
  {
    $datas = $this->model->getBooks(null, $this->level);
    $this->createView($this->_tab . DS . 'list', $datas);
    $this->view->page_title = 'BIBLIOGRAPHIE';
  
    $this->view->render($datas);
  }
  /**
   *  * Gestion vue Book show avec liste des épisodes 
   * @param (int) Id book
   */
  public function show($id)
  { 
    $datas = $this->model->getBooks($id, $this->level);
    $this->createview($this->_tab . DS . 'show', $datas);
    $this->view->page_title = 'à la découverte de :';
    $this->view->render($datas);
  }

  /** Administrateur/ *********************************************************
   * 
   * Gestion vue Book Index
   */
  public function index()
  {
    $datas = $this->model->getBooks(null,$this->level);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_title = 'Gestion du catalogue :';
    $this->view->render($datas);
  }
  /**
  * Gestion vue Book Edit pour maj/add Book 
  * @param mixed Id book ou null
  */
  public function edit($id = null,$opt=null)
  {
    $datas = [];
    
    if((int)($id) > 0):
       $datas = $this->model->getBooks($id,$this->level);
    else:
      $datas[] = new Book([]);
    endif;
    
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->page_title = 'Création/Mise à jour :';
    $this->view->render($datas);
  }

  public function maj($redir = false)
  {
    Session::put('redirect', $this->_tab);
    parent::maj($redir);
  }
}
  