<?php
class EpisodeController extends Controller
{
   
  protected $_tab = 'episode';
  
  // protected $_managerId ;
  // protected $_controllerId ;
 
  protected $level = 'N1';

  
/** Visiteurs/ *********************************************************
 * 
** edit one episode of a known book 
 * @param $ref = id book + id Vol + id episode
*/
public function show($ref= null,$opt=null)
{
  $datas = $this->model->getSelection($ref,  $this->level);
  $this->createview($this->_tab . DS . 'show', $datas);
  $this->view->page_title = 'Un peu de lecture :';
  $this->view->render($datas);

}


/** Administrateur/ *********************************************************
 * 
** list all episodes of a known book 
 * @param $ref = id book
*/
  
  public function index($ref = null)
  {
    $datas = $this->model->getSelection($ref, $this->level);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_title = 'Gestion des épisodes :';
    $this->view->render($datas);
  }

  /** edit one episode of a known book 
 * @param $ref = id book + id Vol + id episode
*/
  public function edit($ref,$opt=null)
  {
    $opt= 'upd';
    $datas = $this->model->getSelection($ref, $this->level);
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->page_title = 'Création/mise à jour épisode :';
    $this->view->render($datas);
  }

}
  