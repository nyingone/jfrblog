<?php
class CommentController extends Controller
{
  public $data = [];
  public $_tab = 'comment';
  public $_entity = 'Comment';
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

/** list all Comments of a known book 
 * @param $ref = id book
*/
  
  public function index($ref = null)
  {
    
    $this->createModel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_object  = 'Commentaires en ligne';
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

  /** edit one Comment of a known book 
 * @param $ref = id Comment
*/
 

  public function show($ref= null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    var_dump($ref);
    $this->createview($this->_tab . DS . 'show', $datas);
    $comment = $datas[0];
      
    $this->view->page_object  = 'commentaires';

    
    $this->view->page_inzcst($ref,$opt);
   
    $this->view->render($datas, $infos[0]);
   
  }

   /** signal a Comment 
 * @param $ref = id Comment $opt=pro/con
*/
public function signal($ref, $opt=null)
{
  // $this->createmodel($this->_tab, '');
  $_POST['url'] = $_SESSION['redirect']; 
  $redir = false;
  $this->maj($redir);
  var_dump($_POST); die;
  exit;
  
}
  
  public function isValid($opt=null)
  {
    $this->result = $this->validate->check($_POST, $this->_tab, 
    $this->_entity::validation() ); 
    return     $this->result;
  }

  
  
}
  