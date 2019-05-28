<?php
class BookController extends Controller
{
/** create all the actions we can have */
    public function index()
    {
       echo 'I am in: ' . __CLASS__ . ' and method is : ' . __METHOD__ ;
      ;
        $this->model('book', 'findAll');
        var_dump($this);
        // var_dump($this->model->inventory); inaccessible protected
        $this->view('book' . DS . 'index', $this->model->inventory);
        // var_dump($this); exit;
        $this->view->page_title = "This is our Bibliographie page";
        $this->view->render();
        // var_dump($this->model);
    }

    public function edit()
    {
        
    }
}
