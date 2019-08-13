<?php
class HomeController extends Controller
{
    private $_tag = 'home';
    protected $_levelEps = 'N1'; // niveau episode
    protected $_levelBook = 'N0';    // niveau book
   /*********************************************************** 
    * 
    */
    public function __construct()
    {
        $this->controllerId = ucfirst($this->_tag . 'Controller');
        $this->managerId = ucfirst($this->_tag . 'Manager');
        $this->createModel($this->_tag, '');
        $this->chgBookPromotedList();
    }
    
    /***********************************************************
    * 
    * Gestion vue "ACCUEIL""
    */
    public function index($id='',$name='')
    {
        $this->createView('home\index',[
                                    'name' => $name,
                                    'id'   => $id ]);
        $this->view->page_title = 'ACCUEIL';
        $datas = $this->model->findLastEpisode($this->_levelEps);
        $this->view->render($datas);
    }

    /* 
    * Gestion vue "About JFR""
    */
    public function aboutJFR()
    {
        $this->createview('home\aboutJFR');
        $this->view->page_title = "This is all about Jean";
        $datas = $this->model->findAboutJFR();
        $this->view->render($datas);
       
    }

    /* 
    * récup. donnée pour affichages variables Header et footer
    */
    public function chgBookPromotedList()
    {
        $datas = $this->model->bookPromotedList($this->_levelBook);
       // var_dump($datas); 
        if($datas !== null && is_array($datas)) :
            $_SESSION['promoted'] = $datas[0];
            if(isset($datas[1]) && !empty($datas[1])) :
                $_SESSION['printed'] = $datas[1];
            endif;
        endif;
    }
    
}