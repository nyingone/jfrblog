<?php
class HomeController extends Controller
{
    private $_tag = 'home';
   //  private $_tab = 'episode';
    // private $_entity = 'Episode';
    protected $level = 'N1'; // niveau episode

    public function __construct()
    {
        $this->controllerId = ucfirst($this->_tag . 'Controller');
        $this->managerId = ucfirst($this->_tag . 'Manager');
        $this->createModel($this->_tag, '');
    }
    
    public function index($id='',$name='')
    {
        $this->createView('home\index',[
                                    'name' => $name,
                                    'id'   => $id ]);
        $this->view->page_title = 'ACCUEIL';
        $datas = $this->model->findLastEpisode($this->level);
        $this->view->render($datas);
    }

    

    public function aboutJFR()
    {
        $this->createview('home\aboutJFR');
        $this->view->page_title = "This is all about Jean";
        $datas = $this->findAboutJFR();
        $this->view->render($datas);
       
    }
    public function findAboutJFR()
    {
        $manager = new EpisodeManager();
        $datas  =   $manager->findAboutJFR(null, $this->level);
        return $datas;
    }  
}