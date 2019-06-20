<?php
class EpisodeController extends Controller
{
  public $data = [];
  private $_tab = 'episode';
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

  public function show($ref,$opt=null)
  {
    $this->createmodel($this->_tab, '');
    $datas = $this->model->getSelection($ref);
    $this->createview($this->_tab . DS . 'show', $datas);
    $this->view->page_object  = 'Episodes';
    $this->view->page_inzcst($ref,$opt);
    $this->view->render($datas);
  }

  public function maj()
  {
    if($this->validate->check($_POST, 'Episode'))
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
  //  quote``content``excerpt``createdDat``status``onlineDate`
  // `commented``nbComment``bookId``chapter``version``slugEps` -->
      $isValid  = $this->validate->check($_POST, $this->_tab, array(
        'id'                =>array(
            'Reference'     =>'Identifiant',
            'required'      => false
        ),
        'quote'             =>array(
            'Reference'     =>'Entête',
            'required'      => true,
            'min'           => 3,
            'max'           => 50
        ),
        'content'             =>array(
            'Reference'     =>'texte',
            'required'      => true,
            'min'           => 10,
            'max'           => 600
        ),
        'excerpt'             =>array(
          'Reference'     =>'extrait',
          'required'      => true,
          'min'           => 10,
          'max'           => 600
        ),
        'createdDat'         =>array(
        'Reference'       =>'Date de création',
        'required'        => false,    
        ),
        'status'             =>array(
          'Reference'     =>'statut',
          'required'      => true,
          'max'           => 2,
          'list'          => '00;10;30;80;90'
        ),
        'onlineDat'         =>array(
            'Reference'     =>'En ligne le',
            'required'      => false,    
        ),
        'commented'         =>array(
          'Reference'     =>'Commenté le',
          'required'      => false,    
        ),
        'nbComment'             =>array(
            'Reference'     =>'Nb Commentaires',
            'required'      => false
        ),
        'bookId'          =>array(
          'Reference'     =>'Ref. livre',
          'required'      => true,
          'int'           => true
        ), 
        'chapter'          =>array(
          'Reference'     =>'Chapître',
          'required'      => true,
          'max'           => 3
        ),
        'version'          =>array(
          'Reference'     =>'version',
          'required'      => true,
          'max'           => 4
        ),
        'slugEps'         =>array(
          'Reference'     =>'Slug',
          'required'      => false,
          'max'           => 30
        )
      )); 
    }
    return( $isValid);
  }
    
}
  