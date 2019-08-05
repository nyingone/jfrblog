<?php
class HomeController extends Controller
{
    private $_tag = 'home';
    private $_tab = 'episode';
    private $_entity = 'Episode';

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
                                    'id'   => $id
        ]);
        $datas = $this->findLastEpisode();
        $this->view->render($datas);
    }

    public function findLastEpisode()
    {
        $manager = new EpisodeManager();
        $datas  =   $manager->findLast();
        return $datas;
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
        $datas  =   $manager->findAboutJFR();
        return $datas;
    }  
}