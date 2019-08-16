<?php
class CommentController extends Controller
{
 
  protected $_tab = 'comment';
  protected $level = 'N2';
 
 /** list all Comments of a known book 
 * @param $ref / explode('.',$parms)=> idBook idEps idComm
*/
    public function index($ref = null)
  {
    $datas = $this->model->getSelection($ref, $this->level);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_title = 'Gestion expression directe :';
    isset($datas) ? $this->view->render($datas) : header("Location: ". Session::get('redirect'));
  }

  public function maj($redir = false)
  {
    $redir = false;
    parent::maj($redir);
    header("Location: ". Session::get('redirect'));
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

  /** maj Comment 
  * @param $ref = id Comment 
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
    $this->maj();
   
  }

  /** Récup infos et Appel à complément $POST
  * @param $ref = id Comment 
  */
  public function inzPost($id)
  {
    $datas = $this->model->getCommentId($id);
    $comment = $datas[0];
    $comment->inz_POST($comment);   
  }

  /** Gestion redirection avant maj. centralisée
  * @param $ref = id Comment 
  */
  

     
}
  