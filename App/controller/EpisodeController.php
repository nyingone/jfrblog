<?php
class EpisodeController extends Controller
{
  public $data = [];
  public $_tab = 'episode';
  public $_entity = 'Episode';
  private $_controller ;
  private $_manager ;
  private $_controllerId ;
  private $_managerId ;
  protected $result=[] ;

  public function __construct()
  {
  $this->_controllerId = ucfirst($this->_tab . 'Controller');
  $this->createModel($this->_tab, '');
  $this->_managerId = ucfirst($this->_tab . 'Manager');
  $this->validate = new Validate();
  }

/** list all episodes of a known book 
 * @param $ref = id book
*/
  
  public function index($ref = null)
  {
    
    $this->createModel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_object  = 'episodes en ligne';
    $this->view->page_inzcst();
    if(isset($ref) && !empty($ref)) 
    {
      $keys = explode('.',$ref);
      $infos = $this->findBookInfos($keys[0]);
      $this->view_infos = $infos[0];
      $book = $this->view_infos;
      $this->view->page_title = $book->getTitle();
    } 
    if(!isset($infos))
    {
      $infos = [];
    }
    $this->view->render($datas, $infos[0] ? $infos[0] : '');
  }

  /** edit one episode of a known book 
 * @param $ref = id book + id Vol + id episode
*/
  public function edit($ref,$opt=null)
  {
    $opt= 'upd';
    
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createview($this->_tab . DS . 'edit', $datas);
    $episode = $datas[0];   
    $infos = $this->findBookInfos($episode->getBookId()); 
   
    $this->view_infos = $infos[0];

    $this->view->page_object  = 'Episode';
    $this->view->page_inzcst($ref,$opt);
    $book = $this->view_infos;
    $this->view->page_title = $book->getTitle();

    $refEps= $episode->getBookId() . '.' . $episode->getId();  
    $comments = $this->findCommentInfos($refEps);
    $this->view_comments = $comments;
  
    $this->view->render($datas, $infos, $comments);
  }

  /** edit one episode of a known book 
 * @param $ref = id book + id Vol + id episode
*/
  public function show($ref= null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createview($this->_tab . DS . 'show', $datas);
    
    $episode = $datas[0];
    $refEps= $episode->getBookId() . '.' . $episode->getId();  

    $infos = $this->findBookInfos($episode->getBookId());
    $this->view_infos = $infos[0];
    
    $this->view->page_object  = 'Episode';
    
    $this->view->page_inzcst($ref,$opt);
    $book = $this->view_infos;
    $this->view->page_title = $book->getTitle();

    $comments = $this->findCommentInfos($refEps);
    $this->view_comments = $comments;
   
    $this->view->render($datas, $infos[0],$comments);
  
  }
  
  public function isValid($opt=null)
  {
    $this->result = $this->validate->check($_POST, $this->_tab, 
     $this->_entity::validation() ); 
    return     $this->result;
  }

/** edit one episode of a known book 
 * @param $ref = id book 
 * @return [objet Book]
*/
  public function findBookInfos($bookId)
  {
    $manager = new BookManager();
    $infos  = $manager->getBooks($bookId);
    //  var_dump($infos); ok array avec un objet book
    return $infos;
  }  

  /** edit one episode of a known book 
 * @param $ref = id book + id Vol + id episode
 * @return [objets Comment]
*/
  public function findCommentInfos($refEps)
  {
    $manager = new CommentManager();
    $comments  = $manager->getSelection($refEps);
    return $comments;
  }  
}
  