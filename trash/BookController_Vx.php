<?php
class BookController extends Controller
{
  public $data = [];
  private $_tab = 'book';
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

/** create all the actions we can have */
  
  public function index()
  {
  /**
   * charger le manager et les données à transmettre à la vue
   * le Controller amont crée le modèle avec  public function model($modelName,$datas=[])
   */
    $this->createModel($this->_tab, '');
    $datas = $this->model->getBooks();
    $this->createView($this->_tab . DS . 'index', $datas);
    $this->view->page_object  = 'bibliographie';
    $this->view->page_inzcst();
    $this->view->render($datas);
  
  }
  public function edit($id,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getBooks($id);
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->page_object  = 'livre';
    $this->view->page_inzcst($id,$opt);
    $this->view->render($datas);
  }

  public function show($id,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getBooks($id);
    $this->createview($this->_tab . DS . 'edit', $datas);
    $this->view->page_object  = 'livre';
    $this->view->page_inzcst($id,$opt);
    $this->view->render($datas);
  }

  public function maj()
  {
    if($this->validate->check($_POST, 'Book'))
    {
      $this->model->majTab($_POST);
    }else {     
      if(!empty($this->validate->errors()))
    {
        foreach($this->validate->errors() as $error)
        {
            echo '<br/>',  $error, '<br/>';
        }
        echo '<br/>';
        return  $this->validate->errors(); 
    }
    }
  }

  public function isValid()
  {
    if($_POST['action'] = 'del')
    {
      $isValid = true;
    }else{
      $this->validate = new Validate();
      $isValid  = $this->validate->check($_POST, $this->_tab, array(
        'id'                =>array(
            'Reference'     =>'Identifiant',
            'required'      => false
        ),
        'title'             =>array(
            'Reference'     =>'Titre',
            'required'      => true,
            'min'           => 3,
            'max'           => 50
        ),
        'plot'             =>array(
            'Reference'     =>'trame',
            'required'      => true,
            'min'           => 10,
            'max'           => 600
        ),
        'onlineDat'         =>array(
            'Reference'     =>'En ligne',
            'required'      => false,    
        ),
        'nbEps'             =>array(
            'Reference'     =>'Nb Episodes',
            'required'      => false
        ),
        'status'             =>array(
            'Reference'     =>'statut',
            'required'      => true,
            'max'           => 2,
            'list'          => '00;10;30;80;90'
        ),
        'isbn'             =>array(
            'Reference'     =>'isbn',
            'required'      => false,
            'max'           => 20
            // 'unique'        => 'book'
        ),
        'editYear'          =>array(
            'Reference'     =>'Année édit°',
            'required'      => false,
            'max'           => 4
        )
      )); 
    }
    return( $isValid);
  }
    
}
  