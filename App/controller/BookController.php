<?php
class BookController extends Controller
{
  public $inventory =[];
  public $data = '';

/** create all the actions we can have */
    public function index()
    {
       echo 'I am in: ' . __CLASS__ . ' and method is : ' . __METHOD__ ;
      ;
      $inventory = [];
      $this->model('book', 'findAll');
    // $this->data = $this-model('book', $inventory)->findAll();

        var_dump($this->data);   // on a perdu les données inventory ???????????
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
