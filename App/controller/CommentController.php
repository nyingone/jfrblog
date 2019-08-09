<?php
class CommentController extends Controller
{
 
  protected $_tab = 'comment';
  //  public $_entity = 'Comment';
  // private $_controller ;
  // private $_manager ;
  // private $_controllerId ;
  // private $_managerId ;
  protected $level = 'N2';
 //  protected $result=[] ;

 
/** list all Comments of a known book 
 * @param $ref = id book
*/
    public function index($ref = null)
  {
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
    ($id) ? $datas = $this->model->getSelection($id,$this->level) : $datas[] = new Book();
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->render($datas);
  }
     
}
  