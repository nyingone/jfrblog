<?php
class BookController extends Controller
{
 
  protected $_tab = 'book';
  protected $level='N0' ;
  
/** Visiteurs/ *********************************************************
 * 
   * Visiteurs/Gestion vue liste Book 
   */
  public function list()
  {
    $datas = $this->model->getBooks(null, $this->level);
    $this->createView($this->_tab . DS . 'list', $datas);
    $this->view->page_title = 'BIBLIOGRAPHIE';
    $this->view->render($datas);
  
  }
  /**
   * Visiteurs/Gestion vue un Book avec liste des épisodes 
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
   * Gestion vue Index Book 
   * 
   */
  public function index()
  {
    $datas = $this->model->getBooks(null,$this->level);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_title = 'Gestion du catalogue :';
    $this->view->render($datas);
  }
/**
 * vue Edit pour maj/add Book 
 */
  public function edit($id = null,$opt=null)
  {
    $datas = $this->model->getBooks($id,$this->level);
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->page_title = 'Création/Mise à jour :';
    $this->view->render($datas);
  }

}
  