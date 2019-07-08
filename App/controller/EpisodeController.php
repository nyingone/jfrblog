<?php
class EpisodeController extends Controller
{
  public $data = [];
  private $_tab = 'episode';
  private $_entity = 'Episode';
  private $_controller ;
  private $_manager ;
  private $_controllerId ;
  private $_managerId ;
  protected $validate ;

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
  
  public function index($id)
  {
    $this->createModel($this->_tab, '');
    $datas = $this->model->getSelection();
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_object  = 'episodes en ligne';
    $this->view->page_inzcst();
    $this->view->render($datas);
  }
  public function edit($ref,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
 
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->page_object  = 'Episodes';
    $this->view->page_inzcst($ref,$opt);
    $this->view->render($datas);
  }

  public function show($ref= null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createview($this->_tab . DS . 'show', $datas);
    $this->view->page_object  = 'Episode';
    $this->view->page_inzcst($ref,$opt);
    $this->view->render($datas);
  }
  
  public function isValid()
  {
    $this->result = $this->validate->check($_POST, $this->_tab, 
     $this->_entity::validation() ); 
    return     $this->result;
  }
}
  