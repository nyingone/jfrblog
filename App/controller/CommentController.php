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
  protected $level = 'N2';
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
    $datas = $this->model->getSelection($ref, $this->level);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_title = 'Gestion expression directe :';
    // var_dump($_SESSION['redirect']);
    isset($datas) ? $this->view->render($datas) : header("Location: ". $_SESSION['redirect'] );
  }

  /** edit one Comment of a known book 
 * @param $ref = id Comment
*/
   public function show($ref= null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref, $this->level);
    $this->createview($this->_tab . DS . 'show', $datas);
    $this->view->render($datas);
  }

   /** signal a Comment 
 * @param $ref = id Book + id Eps + IdComment $opt=pro/con
  */
  public function signal($ref, $opt=null)
  {
    $parms = explode('.', $ref);
    $id = $parms[2];
    
    $this->gest($id);
  }

   /** maj a Comment via gestion Admin
 * @param $ref = id Comment $opt=pro/con
  */
  public function gest($ref, $opt=null)
  {
    if(isset($_POST['url'])) :
      $url = explode('/', $_POST['url']);
    else:
      $url = explode('/', $_GET['url']);
    endif;
    $parms = explode('-', $url[1]);
    $_POST['action'] = $parms[0];
    $this->inzPost($ref);
    $_POST['url'] = $_SESSION['redirect']; 
    $this->maj();
   
  }
  public function inzPost($id)
  {
    $datas = $this->model->getCommentId($id);
    $comment = $datas[0];
    $comment->inz_POST($comment);   
  }
  public function maj($redir=null)
  {
    // var_dump($_SESSION);
    $_POST['url'] =  $_SESSION['redirect']; 
    $redir  = false;
    parent:: maj($redir);
    exit;
  }
  public function edit($id = null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    ($id) ? $datas = $this->model->getSelection($id,$this->level) : $datas[] = new Book();
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->render($datas);
  }
  /** 
   * @param $ref = id book / idEps /id Comm
  */
  

  
  public function isValid($opt=null)
  {
      $this->result = $this->validate->check($_POST, $this->_tab, 
      $this->_entity::validation() ); 

      return     $this->result;
  
  }

  
  
}
  