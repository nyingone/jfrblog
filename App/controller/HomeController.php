<?php
class HomeController extends Controller
{
    private $_tag = 'home';
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
        $this->view->page_object  = 'Home page';
        $this->view->page_inzcst();
        $this->view->render();
    }

    public function aboutJFR()
    {
        $this->createview('home\aboutJFR');
        $this->view->page_title = "This is all about Jean";
        $this->view->render();
    }
}