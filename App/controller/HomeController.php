<?php
class HomeController extends Controller
{
    public function index($id='',$name='')
    {
       echo 'I am in: ' . __CLASS__ . ' and method is : ' . __METHOD__ ;
        $this->view('home\index',[
                                    'name' => $name,
                                    'id'   => $id
        ]);
        // var_dump($this); exit;
        $this->view->page_title = "This is our Home page";
        $this->view->render();
    }

    public function aboutJFR()
    {
        $this->view('home\aboutJFR');
        $this->view->page_title = "This is all about Jean";
        $this->view->render();
    }
}