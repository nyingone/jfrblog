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
    $this->view->render($datas);
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
    $this->view->render($datas);
  }

  /** edit one episode of a known book 
 * @param $ref = id book + id Vol + id episode
*/
  public function show($ref= null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createview($this->_tab . DS . 'show', $datas);
    $episode = $datas[0]; // objet episode
    $this->view->render($datas);
  
  }
  
  public function isValid($opt=null)
  {
    $this->result = $this->validate->check($_POST, $this->_tab, 
     $this->_entity::validation() ); 
    return     $this->result;
  }


}
  