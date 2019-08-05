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
    $this->view->render($datas);
  }

  /** edit one Comment of a known book 
 * @param $ref = id Comment
*/
 

  public function show($ref= null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createview($this->_tab . DS . 'show', $datas);
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
    exit; 
  }

  public function edit($id = null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    ($id) ? $datas = $this->model->getBooks($id,$this->level) : $datas[] = new Book();
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
  