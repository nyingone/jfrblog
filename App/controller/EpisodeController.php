<?php
class EpisodeController extends Controller
{
   
  protected $_tab = 'episode';
  protected $level = 'N1';

  
  /** Visiteurs/ *********************************************************
   * 
  ** Gestion de la vue Episode show
  * @param $ref = id book + id Vol + id episode
  */
  public function show($ref= null,$opt=null)
  {
    $datas = $this->model->getSelection($ref,  $this->level);
    if($datas !==null) :
      $this->createview($this->_tab . DS . 'show', $datas);
      $this->view->page_title = 'Un peu de lecture :';
      $this->view->render($datas);
    else:           // no episode found.
      header("Location: ". Session::get('redirect') );
    endif;

  }

/** Administrateur/ *********************************************************
 * called only from ADMIN book index
** list all episodes of a known book 
* @param $ref = id book
*/ 
  public function index($ref = null)
  {  
    $datas = $this->model->getSelection($ref, $this->level);
    
    if($datas !==null) :
      $this->createView($this->_tab . DS . 'index', $datas);
      $this->view->page_title = 'Gestion des épisodes :';
      $this->view->render($datas);
    else:           // first episode to create for this book.
      $redirect = HOME . 'episode-edit/edit-'.  $ref;
      header("Location: ". $redirect );
      $this->edit($ref);
    endif;
  }

/** edit one episode of a known book 
* @param $ref = id book + id Vol + id episode
*/
  public function edit($ref,$opt=null)
  {
    $keys = explode('.',$ref);
    $bookId = $keys[0];
    $opt= 'upd'; 

    if(isset($keys[1]) && (int) $keys[1] > 0) :
        $datas = $this->model->getSelection($ref, $this->level);
    else:
      // first episode to create for this book.
      $episode = new Episode([]);
      $manager   = new BookManager;
      $bookInfo   = $manager->getBooks($bookId,$this->level);
      $episode->setBookInfo($bookInfo);
      $datas [] = $episode;
    endif;
    
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->page_title = 'Création/mise à jour épisode :';
    $this->view->render($datas);
  }

}
  