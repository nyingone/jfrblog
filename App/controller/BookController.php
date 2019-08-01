<?php
class BookController extends Controller
{
  public $data = [];
  private $_tab = 'book';
  private $_entity = 'Book';
  private $_controller ;
  private $_manager ;
  private $_controllerId ;
  private $_managerId ;
  protected $level='N0' ;

  
  public function __construct()
  {
  $this->_controllerId = ucfirst($this->_tab . 'Controller');
  $this->createModel($this->_tab, '');
  $this->_managerId = ucfirst($this->_tab . 'Manager');
  $this->validate = new Validate();
  }

/** create all the actions we can have */
  
  public function index()
  {
  /**
   * charger le manager et les données à transmettre à la vue
   * le Controller amont crée le modèle avec  public function model($modelName,$datas=[])
   */
    $this->createModel($this->_tab, '');
    $datas = $this->model->getBooks(null,$this->level);
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_object  = 'bibliographie';
    $this->view->page_inzcst();
    $this->view->render();
  
  }
  public function list()
  {
  /**
   * 
   */
    $this->createModel($this->_tab, '');
    $datas = $this->model->getBooks(null, $this->level);
    $this->createView($this->_tab . DS . 'list', $datas);
    $this->view->render();
  
  }
  public function show($id)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getBooks($id, $this->level);
    $this->createview($this->_tab . DS . 'show', $datas);
    /* $infos  = $this->getEpisodeInfos($id);
    $this->view_infos = $infos;
    $this->view->page_object  = '';
    $this->view->page_inzcst(); 
    $this->view->render($datas, $infos); */
    $this->view->render();
  }


  public function edit($id = null,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    ($id) ? $datas = $this->model->getBooks($id,$this->level) : $datas[] = new Book();
    $this->createview($this->_tab . DS . 'edit', $datas);
    /* $infos  = $this->getEpisodeInfos($id);
    $this->view->page_object  = 'livre';
    $this->view->page_inzcst($id,$opt);
    $this->view->render($datas,$infos); */
    $this->view->render($datas);
  }

    public function maj($redirect=null)
  {
    $result = $this->isValid();
    $ok = $result[0];
    if($ok)
    {
      if (isset($result[1]) && !empty($result[1]))
      {
        $class = $result[1];
        $this->model->majTab($class);
        $this->createView($this->_tab );
        $this->view->redirect($this->_tab);
      }
     
    }else {     
        $_SESSION['errors'] = $this->validate->errors();
        $this->createview($this->_tab . DS . 'edit', $datas);
        $this->view->redirect($_SESSION['redirect']);
      // } 

    }
  }

  public function isValid($opt=null)
  {
    var_dump($this);
    $this->result = $this->validate->check($_POST, $this->_tab, 
     $this->_entity::validation() ); 
      return     $this->result;
  }
    
}
  