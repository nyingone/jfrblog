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
        $this->view->page_title = "Our last episode !";
        $this->view->page_object  = 'Home page';
        $this->view->page_inzcst();
        $episode = $datas[0];
        $infos = $this->findBookInfos($episode->getBookId());
        $this->view_infos = $infos[0];
        $this->view->render($datas, $infos[0]);
    }

    public function findLastEpisode()
    {
        $manager = new EpisodeManager();
        $datas  =   $manager->findLast();
        return $datas;
    }   
    public function findBookInfos($bookId)
    {
        $manager = new BookManager();
        $infos  = $manager->getBooks($bookId);
       //  var_dump($infos); ok array avec un objet book
        return $infos;
    }   

    public function aboutJFR()
    {
        $this->createview('home\aboutJFR');
        $this->view->page_title = "This is all about Jean";
        $datas = $this->findAboutJFR();
       
        $this->view->page_inzcst();
        $episode = $datas[0];
        $infos = $this->findBookInfos($episode->getBookId());
        $this->view_infos = $infos[0];
        $this->view->render($datas, $infos[0]);
       
    }
    public function findAboutJFR()
    {
        $manager = new EpisodeManager();
        $datas  =   $manager->findAboutJFR();
        return $datas;
    }  
}